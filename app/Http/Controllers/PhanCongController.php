<?php

namespace App\Http\Controllers;

use App\Models\HuongDanVien;
use App\Models\LichKhoiHanhTour;
use App\Models\PhanCong;
use App\Models\PhuongTien;
use Illuminate\Http\Request;

class PhanCongController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:phan_cong.view')->only(['index', 'show']);
        $this->middleware('permission:phan_cong.create')->only(['create', 'store']);
        $this->middleware('permission:phan_cong.edit')->only(['edit', 'update']);
        $this->middleware('permission:phan_cong.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $phanCongs = LichKhoiHanhTour::with([
            'tour',
            'phanCong.hdv',
            'phanCong.phuongTien',
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
            ->where(function ($query) {
                $query->whereHas('phanCong')
                    ->orWhere('trang_thai', 'finalized');
            })
            ->orderBy('ngay_khoi_hanh', 'asc')
            ->paginate(10);

        return view(
            'Admin.phan_cong.index',
            compact('phanCongs', 'keyword')
        );
    }
    public function show(LichKhoiHanhTour $phanCong)
    {
        return view('Admin.phan_cong.show', compact('phanCong'));
    }
    public function create(Request $request)
    {


        $lichKhoiHanhs = LichKhoiHanhTour::findOrFail($request->id);


        $huongDanViens = HuongDanVien::where('trang_thai', 'san_sang')->get();
        $phuongTiens = PhuongTien::where('trang_thai', 1)->get();

        return view(
            'Admin.phan_cong.create',
            compact('lichKhoiHanhs', 'huongDanViens', 'phuongTiens')
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'lich_khoi_hanh_id' => 'required|exists:lich_khoi_hanh_tours,id',
            'hdv_ids'            => 'required|array|min:1',
            'hdv_ids.*'          => 'required|distinct|exists:huong_dan_viens,id',
            'phuong_tien_ids'    => 'required|array|min:1',
            'phuong_tien_ids.*'  => 'required|distinct|exists:phuong_tiens,id',
        ]);

        $selectedVehicleIds = $request->input('phuong_tien_ids', []);
        $selectedHdvIds = $request->input('hdv_ids', []);

        if (count($selectedHdvIds) < count($selectedVehicleIds)) {
            return back()
                ->withInput()
                ->withErrors([
                    'hdv_ids' => 'Số lượng HDV phải lớn hơn hoặc bằng số lượng phương tiện.'
                ]);
        }

        $lich = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);

        $ngayBatDau = $lich->ngay_khoi_hanh;
        $ngayKetThuc = $lich->ngay_ket_thuc;

        $phuongTiens = PhuongTien::whereIn('id', $selectedVehicleIds)->get();
        $totalSeats = $phuongTiens->sum(function ($vehicle) {
            return $vehicle->so_cho ?? (int) preg_replace('/\D/', '', $vehicle->loai_phuong_tien);
        });

        $soKhach = $lich->tour->so_khach_toi_da;

        if ($totalSeats < $soKhach) {
            return back()
                ->withInput()
                ->withErrors([
                    'phuong_tien_ids' => 'Tổng số chỗ của phương tiện chưa đủ cho đoàn khách.'
                ]);
        }
        /**
         * ==========================
         * Kiểm tra HDV có bị trùng lịch
         * ==========================
         */

        $hdvBusy = PhanCong::whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

            $query->where(function ($q) use ($ngayBatDau, $ngayKetThuc) {

                $q->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                    ->where('ngay_ket_thuc', '>=', $ngayBatDau);
            });
        })
            ->where(function ($query) use ($selectedHdvIds) {
                foreach ($selectedHdvIds as $hdvId) {
                    $query->orWhereJsonContains('hdv_ids', $hdvId)
                        ->orWhere('hdv_id', $hdvId);
                }
            })
            ->exists();

        if ($hdvBusy) {

            return back()
                ->withInput()
                ->withErrors([
                    'hdv_ids' => 'Một trong các HDV đã bị trùng lịch trong thời gian này.'
                ]);
        }

        /**
         * ==========================
         * Kiểm tra xe có bị trùng lịch
         * ==========================
         */

        $xeBusy = PhanCong::whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

            $query->where(function ($q) use ($ngayBatDau, $ngayKetThuc) {

                $q->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                    ->where('ngay_ket_thuc', '>=', $ngayBatDau);
            });
        })
            ->where(function ($query) use ($selectedVehicleIds) {
                foreach ($selectedVehicleIds as $vehicleId) {
                    $query->orWhereJsonContains('phuong_tien_ids', $vehicleId)
                        ->orWhere('phuong_tien_id', $vehicleId);
                }
            })
            ->exists();

        if ($xeBusy) {

            return back()
                ->withInput()
                ->withErrors([
                    'phuong_tien_ids' => 'Một trong các phương tiện đang được sử dụng cho tour khác trong thời gian này.'
                ]);
        }

        /**
         * ==========================
         * Lưu phân công
         * ==========================
         */

        PhanCong::create([

            'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,
            'hdv_id' => $selectedHdvIds[0],
            'phuong_tien_id' => $selectedVehicleIds[0],
            'hdv_ids' => $selectedHdvIds,
            'phuong_tien_ids' => $selectedVehicleIds,
            'ghi_chu' => $request->ghi_chu,
            'ngay_phan_cong' => now(),

        ]);

        // Cập nhật trạng thái lịch
        $lich->update([

            'huong_dan_vien_id' => $selectedHdvIds[0],
            'trang_thai' => 'assigned' // Đã phân công

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

        $existingHdvIds = $phanCong->hdv_ids ?? [$phanCong->hdv_id];
        $huongDanViens = HuongDanVien::where(function ($q) use ($existingHdvIds) {
            $q->whereIn('trang_thai', [
                'san_sang',
                'hoat_dong'
            ])
                ->orWhereIn('id', array_filter($existingHdvIds));
        })->get();

        $existingVehicleIds = $phanCong->phuong_tien_ids ?? [$phanCong->phuong_tien_id];
        $phuongTiens = PhuongTien::where(function ($q) use ($existingVehicleIds) {
            $q->where('trang_thai', 1)
                ->orWhereIn('id', array_filter($existingVehicleIds));
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
            'hdv_ids'            => 'required|array|min:1',
            'hdv_ids.*'          => 'required|distinct|exists:huong_dan_viens,id',
            'phuong_tien_ids'    => 'required|array|min:1',
            'phuong_tien_ids.*'  => 'required|distinct|exists:phuong_tiens,id',
            'ghi_chu'            => 'nullable|string|max:500',
        ]);
        try {
            $selectedVehicleIds = $request->input('phuong_tien_ids', []);
            $selectedHdvIds = $request->input('hdv_ids', []);

            if (count($selectedHdvIds) < count($selectedVehicleIds)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'hdv_ids' => 'Số lượng HDV phải lớn hơn hoặc bằng số lượng phương tiện.'
                    ]);
            }

            $lich = $phanCong->lichKhoiHanh;
            $ngayBatDau = $lich->ngay_khoi_hanh;
            $ngayKetThuc = $lich->ngay_ket_thuc;
            // Chỉ cho sửa khi chưa khởi hành


            $phuongTiens = PhuongTien::whereIn('id', $selectedVehicleIds)->get();
            $totalSeats = $phuongTiens->sum(function ($vehicle) {
                return $vehicle->so_cho ?? (int) preg_replace('/\D/', '', $vehicle->loai_phuong_tien);
            });
            $soKhach = $lich->tour->so_khach_toi_da;

            if ($totalSeats < $soKhach) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'phuong_tien_ids' => 'Tổng số chỗ của phương tiện chưa đủ cho đoàn khách.'
                    ]);
            }

            /**
             * Kiểm tra HDV có bị trùng lịch không
             */
            $hdvBusy = PhanCong::where('id', '!=', $phanCong->id)
                ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

                    $query->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                        ->where('ngay_ket_thuc', '>=', $ngayBatDau);
                })
                ->where(function ($query) use ($selectedHdvIds) {
                    foreach ($selectedHdvIds as $hdvId) {
                        $query->orWhereJsonContains('hdv_ids', $hdvId)
                            ->orWhere('hdv_id', $hdvId);
                    }
                })
                ->exists();

            if ($hdvBusy) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'hdv_ids' => 'Một trong các HDV đã bị trùng lịch trong thời gian này.'
                    ]);
            }

            /**
             * Kiểm tra xe có bị trùng lịch không
             */
            $xeBusy = PhanCong::where('id', '!=', $phanCong->id)
                ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {

                    $query->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                        ->where('ngay_ket_thuc', '>=', $ngayBatDau);
                })
                ->where(function ($query) use ($selectedVehicleIds) {
                    foreach ($selectedVehicleIds as $vehicleId) {
                        $query->orWhereJsonContains('phuong_tien_ids', $vehicleId)
                            ->orWhere('phuong_tien_id', $vehicleId);
                    }
                })
                ->exists();

            if ($xeBusy) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'phuong_tien_ids' => 'Một trong các phương tiện đang được phân công cho tour khác trong thời gian này.'
                    ]);
            }

            // Cập nhật phân công
            $phanCong->update([
                'hdv_id'            => $selectedHdvIds[0],
                'phuong_tien_id'    => $selectedVehicleIds[0],
                'hdv_ids'           => $selectedHdvIds,
                'phuong_tien_ids'   => $selectedVehicleIds,
                'ghi_chu'           => $request->ghi_chu,
            ]);

            $lich->update([
                'huong_dan_vien_id' => $selectedHdvIds[0],
            ]);

            return redirect()
                ->route('Admin.phan-cong.index')
                ->with('success', 'Cập nhật phân công thành công.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Đã xảy ra lỗi khi cập nhật phân công: ' . $e->getMessage()
            ]);
        }

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
        $phanCong->delete();

        $lich->update([
            'huong_dan_vien_id' => null,
            'phuong_tien_id'    => null,
            'trang_thai'        => 1,
        ]);

        return redirect()
            ->route('Admin.phan-cong.index')
            ->with(
                'success',
                'Xóa phân công thành công.'
            );
    }
}
