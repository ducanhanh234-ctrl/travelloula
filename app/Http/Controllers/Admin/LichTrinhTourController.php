<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietLichTrinh;
use App\Models\DanhSachTour;
use App\Models\LichTrinhTour;
use Illuminate\Http\Request;


class LichTrinhTourController extends Controller
{
    /**
     * Danh sách tour
     */


    /**
     * Danh sách lịch trình theo tour
     */
    public function index(Request $request)
    {
        $query = DanhSachTour::query();

        // Tìm theo tên tour
        if ($request->filled('keyword')) {
            $query->where('ten_tour', 'like', '%' . $request->keyword . '%');
        }

        // Lọc trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Sắp xếp
        $query->orderBy('created_at', 'desc');

        $tours = $query->select(
            'id',
            'ten_tour',
            'anh_dai_dien',
            'gia_tour',
            'thoi_luong',
            'trang_thai'
        )->get();

        // Thống kê
        $tongTour = DanhSachTour::count();
        $activeTour = DanhSachTour::where('trang_thai', 'active')->count();
        $inactiveTour = DanhSachTour::where('trang_thai', 'inactive')->count();

        return view(
            'Admin.lich_trinh_tours.tour_list',
            compact(
                'tours',
                'tongTour',
                'activeTour',
                'inactiveTour'
            )
        );
    }
    public function indexByTour($tourId)
    {
        $tour = DanhSachTour::findOrFail($tourId);

        $lichTrinhs = LichTrinhTour::where('tour_id', $tourId)
            ->orderBy('ngay_thu')
            ->get();

        // Thống kê
        $tongNgay = $lichTrinhs->count();

        $tongDiaDiem = $lichTrinhs
            ->pluck('dia_diem')
            ->filter()
            ->unique()
            ->count();

        $ngayCuoi = $lichTrinhs->max('ngay_thu') ?? 0;

        return view(
            'Admin.lich_trinh_tours.index',
            compact(
                'tour',
                'lichTrinhs',
                'tongNgay',
                'tongDiaDiem',
                'ngayCuoi'
            )
        );
    }

    /**
     * Form thêm lịch trình
     */
    public function create(Request $request)
    {
        $tour = DanhSachTour::findOrFail(
            $request->tour_id
        );

        return view(
            'Admin.lich_trinh_tours.create',
            compact('tour')
        );
    }

    /**
     * Lưu lịch trình
     */
    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required',
            'ngay_thu' => 'required',
            'tieu_de' => 'required',
        ]);

        LichTrinhTour::create([
            'tour_id' => $request->tour_id,
            'ngay_thu' => $request->ngay_thu,
            'tieu_de' => $request->tieu_de,
            'dia_diem' => $request->dia_diem,
            'hoat_dong' => $request->hoat_dong,
            'bua_an' => $request->bua_an,
            'thong_tin_khach_san' => $request->thong_tin_khach_san,
        ]);

        return redirect()
            ->route(
                'Admin.lich_trinh_tours.tour',
                $request->tour_id
            )
            ->with(
                'success',
                'Thêm lịch trình thành công'
            );
    }

    /**
     * Form sửa
     */
    public function edit($id)
    {
        $lichTrinh = LichTrinhTour::findOrFail($id);

        return view(
            'Admin.lich_trinh_tours.edit',
            compact('lichTrinh')
        );
    }

    /**
     * Cập nhật
     */
    public function update(Request $request, $id)
    {
        $lichTrinh = LichTrinhTour::findOrFail($id);

        $lichTrinh->update([
            'ngay_thu' => $request->ngay_thu,
            'tieu_de' => $request->tieu_de,
            'dia_diem' => $request->dia_diem,
            'hoat_dong' => $request->hoat_dong,
            'bua_an' => $request->bua_an,
            'thong_tin_khach_san' => $request->thong_tin_khach_san,
        ]);

        return redirect()
            ->route(
                'Admin.lich_trinh_tours.tour',
                $lichTrinh->tour_id
            )
            ->with(
                'success',
                'Cập nhật thành công'
            );
    }

    /**
     * Xóa
     */
    public function destroy($id)
    {
        $lichTrinh = LichTrinhTour::findOrFail($id);

        $tourId = $lichTrinh->tour_id;

        $lichTrinh->delete();

        return redirect()
            ->route(
                'Admin.lich_trinh_tours.tour',
                $tourId
            )
            ->with(
                'success',
                'Xóa thành công'
            );
    }
}
