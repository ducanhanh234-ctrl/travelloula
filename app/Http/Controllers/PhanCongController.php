<?php

namespace App\Http\Controllers;

use App\Models\HuongDanVien;
use App\Models\LichKhoiHanhTour;
use App\Models\PhanCong;
use App\Models\PhuongTien;
use Illuminate\Http\Request;

class PhanCongController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $phanCongs = PhanCong::with([
            'lichKhoiHanh',
            'hdv',
            'phuongTien'
        ])
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('hdv', function ($q) use ($keyword) {
                    $q->where('ho_ten', 'like', '%' . $keyword . '%');
                })
                    ->orWhereHas('phuongTien', function ($q) use ($keyword) {
                        $q->where('bien_so_xe', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('lichKhoiHanh', function ($q) use ($keyword) {
                        $q->where('id', 'like', '%' . $keyword . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        return view(
            'Admin.phan_cong.index',
            compact('phanCongs', 'keyword')
        );
    }
    public function show(PhanCong $phanCong)
    {
        return view('Admin.phan_cong.show', compact('phanCong'));
    }
    public function create()
    {
        $lichKhoiHanhs = LichKhoiHanhTour::where('trang_thai', '1')->get();
        $huongDanViens = HuongDanVien::where('trang_thai', 'san_sang')->get();
        $phuongTiens = PhuongTien::where('trang_thai', '1')->get();
        return view('Admin.phan_cong.create', compact('lichKhoiHanhs', 'huongDanViens', 'phuongTiens'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'lich_khoi_hanh_id' => 'required|exists:lich_khoi_hanh_tours,id',
            'hdv_id'            => 'required|exists:huong_dan_viens,id',
            'phuong_tien_id'    => 'required|exists:phuong_tiens,id',
        ]);

        // Lấy lịch khởi hành cần phân công
        $lich = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);

        $ngayBatDau = $lich->ngay_khoi_hanh;
        $ngayKetThuc = $lich->ngay_ket_thuc;
        $xe = PhuongTien::findOrFail($request->phuong_tien_id);

        $soKhach = $lich->tour->so_khach_toi_da;

        if ($xe->loai_phuong_tien < $soKhach) {
            return back()
                ->withInput()
                ->withErrors([
                    'phuong_tien_id' => 'Xe không đủ số chỗ cho đoàn khách.'
                ]);
        }
        /**
         * ==========================
         * Kiểm tra HDV có bị trùng lịch
         * ==========================
         */

        $hdvBusy = PhanCong::where('hdv_id', $request->hdv_id)
            ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

                $query->where(function ($q) use ($ngayBatDau, $ngayKetThuc) {

                    $q->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                        ->where('ngay_ket_thuc', '>=', $ngayBatDau);
                });
            })
            ->exists();

        if ($hdvBusy) {

            return back()
                ->withInput()
                ->withErrors([
                    'hdv_id' => 'Hướng dẫn viên đang được phân công cho tour khác trong thời gian này.'
                ]);
        }

        /**
         * ==========================
         * Kiểm tra xe có bị trùng lịch
         * ==========================
         */

        $xeBusy = PhanCong::where('phuong_tien_id', $request->phuong_tien_id)
            ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

                $query->where(function ($q) use ($ngayBatDau, $ngayKetThuc) {

                    $q->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                        ->where('ngay_ket_thuc', '>=', $ngayBatDau);
                });
            })
            ->exists();

        if ($xeBusy) {

            return back()
                ->withInput()
                ->withErrors([
                    'phuong_tien_id' => 'Phương tiện đang được sử dụng cho tour khác trong thời gian này.'
                ]);
        }

        /**
         * ==========================
         * Lưu phân công
         * ==========================
         */

        PhanCong::create([

            'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,
            'hdv_id' => $request->hdv_id,
            'phuong_tien_id' => $request->phuong_tien_id,
            'ghi_chu' => $request->ghi_chu,
            'ngay_phan_cong' => now(),

        ]);

        // Cập nhật trạng thái lịch
        $lich->update([
            'trang_thai' => 2 // Đã phân công
        ]);

        return redirect()
            ->route('Admin.phan-cong.index')
            ->with('success', 'Phân công thành công.');
    }
    public function edit(PhanCong $phanCong)
    {
        $phanCong->load([
            'lichKhoiHanh',
            'hdv',
            'phuongTien'
        ]);

        $huongDanViens = HuongDanVien::where(function ($q) use ($phanCong) {

            $q->whereIn('trang_thai', [
                'san_sang',
                'hoat_dong'
            ])
                ->orWhere('id', $phanCong->hdv_id);
        })->get();

        $soKhach = $phanCong->lichKhoiHanh->tour->so_khach_toi_da;
        $phuongTiens = PhuongTien::where(function ($q) use ($phanCong, $soKhach) {
            $q->where(function ($query) use ($soKhach) {
                $query->where('trang_thai', 1)
                    ->where('loai_phuong_tien', '>=', $soKhach);
            })
                ->orWhere('id', $phanCong->phuong_tien_id);
        })->get();

        return view(
            'Admin.phan_cong.edit',
            compact(
                'phanCong',
                'huongDanViens',
                'phuongTiens'
            )
        );
    }
    public function update(Request $request, PhanCong $phanCong)
    {
        $request->validate([
            'hdv_id'            => 'required|exists:huong_dan_viens,id',
            'phuong_tien_id'    => 'required|exists:phuong_tiens,id',
            'ghi_chu'           => 'nullable|string|max:500',
        ]);
        $lich = $phanCong->lichKhoiHanh;
        $ngayBatDau = $lich->ngay_khoi_hanh;
        $ngayKetThuc = $lich->ngay_ket_thuc;
        // Chỉ cho sửa khi chưa khởi hành
        if ($lich->trang_thai >= 3) {

            return back()->with(
                'error',
                'Tour đã khởi hành hoặc đã hoàn thành, không thể chỉnh sửa.'
            );
        }

    // Lấy lịch khởi hành


        /**
         * Kiểm tra HDV có bị trùng lịch không
         */
        $hdvBusy = PhanCong::where('id', '!=', $phanCong->id)
            ->where('hdv_id', $request->hdv_id)
            ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

                $query->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                    ->where('ngay_ket_thuc', '>=', $ngayBatDau);
            })
            ->exists();

        if ($hdvBusy) {
            return back()
                ->withInput()
                ->withErrors([
                    'hdv_id' => 'Hướng dẫn viên đã được phân công cho tour khác trong thời gian này.'
                ]);
        }

        /**
         * Kiểm tra xe có bị trùng lịch không
         */
        $xeBusy = PhanCong::where('id', '!=', $phanCong->id)
            ->where('phuong_tien_id', $request->phuong_tien_id)
            ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

                $query->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                    ->where('ngay_ket_thuc', '>=', $ngayBatDau);
            })
            ->exists();

        if ($xeBusy) {
            return back()
                ->withInput()
                ->withErrors([
                    'phuong_tien_id' => 'Phương tiện đã được phân công cho tour khác trong thời gian này.'
                ]);
        }

        // Cập nhật phân công
        $phanCong->update([
            'hdv_id'            => $request->hdv_id,
            'phuong_tien_id'    => $request->phuong_tien_id,
            'ghi_chu'           => $request->ghi_chu,
        ]);

        return redirect()
            ->route('Admin.phan-cong.index')
            ->with('success', 'Cập nhật phân công thành công.');
    }
    public function destroy(PhanCong $phanCong)
    {
        $lich = $phanCong->lichKhoiHanh;

        // Chỉ cho phép xóa khi lịch đang ở trạng thái Đã phân công
        if ($lich->trang_thai != 2) {

            return back()->with(
                'error',
                'Chỉ được xóa phân công khi tour chưa khởi hành.'
            );
        }

        $phanCong->delete();

        // Trả lịch về trạng thái Chờ phân công
        $lich->update([
            'trang_thai' => 1
        ]);

        return redirect()
            ->route('Admin.phan-cong.index')
            ->with(
                'success',
                'Xóa phân công thành công.'
            );
    }
}
