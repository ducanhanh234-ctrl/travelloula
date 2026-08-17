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
        ])->leftJoin('phan_congs', 'phan_congs.lich_khoi_hanh_id', '=', 'lich_khoi_hanh_tours.id')
            ->select('lich_khoi_hanh_tours.*')
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
            ->orderBy('phan_congs.ngay_phan_cong', 'asc')
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

        $soKhach = $lich->tour->so_khach_da_dat;

        if ($totalSeats < $soKhach) {
            return back()
                ->withInput()
                ->withErrors([
                    'phuong_tien_ids' => 'Tổng số chỗ của phương tiện chưa đủ cho đoàn khách.'
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
            $soKhach = $lich->tour->so_khach_da_dat;

            if ($totalSeats < $soKhach) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'phuong_tien_ids' => 'Tổng số chỗ của phương tiện chưa đủ cho đoàn khách.'
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
                'trang_thai' => 'assigned',
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

        if (!$lich) {
            return back()->with(
                'error',
                'Không tìm thấy lịch khởi hành của phân công này.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Chỉ cho xóa phân công trước khi tour khởi hành
        |--------------------------------------------------------------------------
        |
        | assigned = đã phân công nhưng chưa khởi hành.
        | Sau khi xóa, lịch quay lại finalized để Admin phân công lại.
        |
        */
        if ($lich->trang_thai !== 'assigned') {
            return back()->with(
                'error',
                'Chỉ được xóa phân công khi tour đang ở trạng thái Đã phân công và chưa khởi hành.'
            );
        }

        $phanCong->delete();

        $lich->update([
            'huong_dan_vien_id' => null,
            'phuong_tien_id' => null,
            'trang_thai' => 'finalized',
        ]);

        return redirect()
            ->route('Admin.phan-cong.index')
            ->with(
                'success',
                'Đã xóa phân công. Lịch đã quay về trạng thái Đã chốt để phân công lại.'
            );
    }

    /**
     * Lấy danh sách phương tiện không bị trùng lịch
     */
    public function getAvailableVehicles(Request $request)
    {
        $lichKhoiHanhId = $request->input('lich_khoi_hanh_id');
        $excludePhanCongId = $request->input('exclude_phan_cong_id'); // Dùng cho edit

        $lich = LichKhoiHanhTour::findOrFail($lichKhoiHanhId);
        $ngayBatDau = $lich->ngay_khoi_hanh;
        $ngayKetThuc = $lich->ngay_ket_thuc;

        // Lấy danh sách xe bị trùng lịch
        $busyVehicleIds = PhanCong::when($excludePhanCongId, function ($q) use ($excludePhanCongId) {
            $q->where('id', '!=', $excludePhanCongId);
        })
            ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {
                $query->where(function ($q) use ($ngayBatDau, $ngayKetThuc) {
                    $q->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                        ->where('ngay_ket_thuc', '>=', $ngayBatDau);
                });
            })
            ->get()
            ->flatMap(function ($pc) {
                $ids = is_array($pc->phuong_tien_ids) ? $pc->phuong_tien_ids : [$pc->phuong_tien_id];
                return array_filter($ids);
            })
            ->unique()
            ->values()
            ->toArray();

        // Lấy danh sách xe không bị trùng lịch
        $availableVehicles = PhuongTien::where('trang_thai', 1)
            ->whereNotIn('id', $busyVehicleIds)
            ->get()
            ->map(function ($vehicle) {
                return [
                    'id' => $vehicle->id,
                    'bien_so_xe' => $vehicle->bien_so_xe,
                    'loai_phuong_tien' => match($vehicle->loai_phuong_tien) {
                        'xe_45_cho' => 'Xe 45 chỗ',
                        'xe_29_cho' => 'Xe 29 chỗ',
                        'xe_16_cho' => 'Xe 16 chỗ',
                        default => 'Không xác định'
                    },
                    'so_cho' => $vehicle->so_cho ?? (int) preg_replace('/\D/', '', $vehicle->loai_phuong_tien)
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $availableVehicles,
            'message' => count($availableVehicles) > 0 ? '' : 'Không có phương tiện khả dụng trong khoảng thời gian này'
        ]);
    }

    /**
     * Lấy danh sách hướng dẫn viên không bị trùng lịch
     */
    public function getAvailableGuides(Request $request)
    {
        $lichKhoiHanhId = $request->input('lich_khoi_hanh_id');
        $excludePhanCongId = $request->input('exclude_phan_cong_id'); // Dùng cho edit

        $lich = LichKhoiHanhTour::findOrFail($lichKhoiHanhId);
        $ngayBatDau = $lich->ngay_khoi_hanh;
        $ngayKetThuc = $lich->ngay_ket_thuc;

        // Lấy danh sách HDV bị trùng lịch
        $busyGuideIds = PhanCong::when($excludePhanCongId, function ($q) use ($excludePhanCongId) {
            $q->where('id', '!=', $excludePhanCongId);
        })
            ->whereHas('lichKhoiHanh', function ($query) use ($ngayBatDau, $ngayKetThuc) {
                $query->where(function ($q) use ($ngayBatDau, $ngayKetThuc) {
                    $q->where('ngay_khoi_hanh', '<=', $ngayKetThuc)
                        ->where('ngay_ket_thuc', '>=', $ngayBatDau);
                });
            })
            ->get()
            ->flatMap(function ($pc) {
                $ids = is_array($pc->hdv_ids) ? $pc->hdv_ids : [$pc->hdv_id];
                return array_filter($ids);
            })
            ->unique()
            ->values()
            ->toArray();

        // Lấy danh sách HDV không bị trùng lịch
        $availableGuides = HuongDanVien::where(function ($q) use ($busyGuideIds) {
            $q->whereIn('trang_thai', ['san_sang', 'hoat_dong'])
                ->whereNotIn('id', $busyGuideIds);
        })
            ->get()
            ->map(function ($guide) {
                return [
                    'id' => $guide->id,
                    'ho_ten' => $guide->ho_ten
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $availableGuides,
            'message' => count($availableGuides) > 0 ? '' : 'Không có hướng dẫn viên khả dụng trong khoảng thời gian này'
        ]);
    }
}
