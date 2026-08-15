<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckInKhachHang;
use App\Models\CheckinSave;
use App\Models\DatTour;
use App\Models\HuongDanVien;
use App\Models\LichKhoiHanhTour;
use App\Models\PhanCong;
use App\Models\ThayDoiLichTrinh;
use Illuminate\Http\Request;

class AdminCheckInController extends Controller
{
    /**
     * Danh sách lịch khởi hành để Admin theo dõi điểm danh HDV.
     * Chỉ đọc dữ liệu, không có hành động Check-in/Check-out.
     */
    public function __construct()
    {
        $this->middleware('permission:checkin_hdv.view')
            ->only([
                'index',
                'show',
            ]);
    }
    public function index(Request $request)
    {
        $query = LichKhoiHanhTour::with([
            'tour',
            'huongDanVien',
        ])
            // Admin chỉ theo dõi các tour đang diễn ra
            ->where('trang_thai', 'running')
            ->orderBy('ngay_khoi_hanh')
            ->orderBy('id');

        if ($request->filled('q')) {
            $keyword = trim($request->q);

            $query->where(function ($q) use ($keyword) {
                $q->where('id', $keyword)
                    ->orWhereHas('tour', function ($tourQuery) use ($keyword) {
                        $tourQuery->where('ten_tour', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $lichKhoiHanhs = $query
            ->paginate(15)
            ->withQueryString();

        $lichIds = $lichKhoiHanhs->getCollection()->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | Tổng khách theo lịch khởi hành
        |--------------------------------------------------------------------------
        */
        $datTours = DatTour::withCount('khachHangs')
            ->whereIn('lich_khoi_hanh_id', $lichIds)
            ->get()
            ->groupBy('lich_khoi_hanh_id');

        /*
        |--------------------------------------------------------------------------
        | Điểm danh theo lịch khởi hành
        |--------------------------------------------------------------------------
        */
        $checkIns = CheckInKhachHang::whereIn('lich_khoi_hanh_id', $lichIds)
            ->get()
            ->groupBy('lich_khoi_hanh_id');

        /*
        |--------------------------------------------------------------------------
        | HDV được phân công
        |--------------------------------------------------------------------------
        */
        $phanCongs = PhanCong::whereIn('lich_khoi_hanh_id', $lichIds)->get();

        $allGuideIds = collect();

        foreach ($phanCongs as $phanCong) {
            $ids = $phanCong->hdv_ids;

            if (is_string($ids)) {
                $decoded = json_decode($ids, true);
                $ids = is_array($decoded) ? $decoded : [];
            }

            foreach ((array) $ids as $id) {
                $allGuideIds->push((int) $id);
            }
        }

        foreach ($lichKhoiHanhs as $lich) {
            if ($lich->huong_dan_vien_id) {
                $allGuideIds->push((int) $lich->huong_dan_vien_id);
            }
        }

        $guides = HuongDanVien::whereIn('id', $allGuideIds->unique()->values())
            ->get()
            ->keyBy('id');

        $stats = [];
        $guideNames = [];

        foreach ($lichKhoiHanhs as $lich) {
            $bookingRows = $datTours->get($lich->id, collect());

            $tongKhach = $bookingRows->sum('khach_hangs_count');

            $rows = $checkIns->get($lich->id, collect());

            $daCheckIn = $rows
                ->whereIn('trang_thai', ['da_check_in', 'da_check_out'])
                ->count();

            $daCheckOut = $rows
                ->where('trang_thai', 'da_check_out')
                ->count();

            $checkInBu = $rows
                ->where('is_checkin_bu', true)
                ->count();

            $checkOutBu = $rows
                ->where('is_checkout_bu', true)
                ->count();

            $stats[$lich->id] = [
                'tong_khach' => $tongKhach,
                'da_check_in' => $daCheckIn,
                'da_check_out' => $daCheckOut,
                'checkin_bu' => $checkInBu,
                'checkout_bu' => $checkOutBu,
            ];

            $ids = collect();

            if ($lich->huong_dan_vien_id) {
                $ids->push((int) $lich->huong_dan_vien_id);
            }

            $phanCong = $phanCongs
                ->where('lich_khoi_hanh_id', $lich->id)
                ->first();

            if ($phanCong) {
                $phanCongIds = $phanCong->hdv_ids;

                if (is_string($phanCongIds)) {
                    $decoded = json_decode($phanCongIds, true);
                    $phanCongIds = is_array($decoded) ? $decoded : [];
                }

                foreach ((array) $phanCongIds as $id) {
                    $ids->push((int) $id);
                }
            }

            $guideNames[$lich->id] = $ids
                ->unique()
                ->map(function ($id) use ($guides) {
                    $guide = $guides->get($id);

                    return $guide
                        ? ($guide->ho_ten ?? ('HDV #' . $guide->id))
                        : ('HDV #' . $id);
                })
                ->values();
        }

        return view('Admin.checkin_hdv.index', compact(
            'lichKhoiHanhs',
            'stats',
            'guideNames'
        ));
    }

    /**
     * Chi tiết điểm danh của một lịch khởi hành.
     */
    public function show($lichKhoiHanhId)
    {
        $lichKhoiHanh = LichKhoiHanhTour::with([
            'tour.lichTrinhTours.chiTiets',
            'huongDanVien',
        ])->findOrFail($lichKhoiHanhId);

        $datTours = DatTour::with([
            'nguoiDung',
            'khachHangs',
        ])
            ->where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->get();

        $khachHangs = $datTours
            ->flatMap(function ($datTour) {
                return $datTour->khachHangs;
            })
            ->unique('id')
            ->values();

        $tongKhach = $khachHangs->count();

        /*
        |--------------------------------------------------------------------------
        | Tất cả dữ liệu Check-in của lịch hiện tại
        |--------------------------------------------------------------------------
        */
        $allCheckIns = CheckInKhachHang::where(
            'lich_khoi_hanh_id',
            $lichKhoiHanh->id
        )
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Lịch thay đổi thực tế do HDV cập nhật
        |--------------------------------------------------------------------------
        */
        $scheduleChanges = ThayDoiLichTrinh::where(
            'lich_khoi_hanh_id',
            $lichKhoiHanh->id
        )
            ->get()
            ->keyBy('chi_tiet_lich_trinh_id');

        /*
        |--------------------------------------------------------------------------
        | Các trạng thái xác nhận/chốt
        |--------------------------------------------------------------------------
        */
        $saves = CheckinSave::where(
            'lich_khoi_hanh_id',
            $lichKhoiHanh->id
        )->get();

        $departureDone =
            (bool) $lichKhoiHanh->da_checkin_khoi_hanh
            || $saves->where('action', 'CONFIRM_XUATPHAT')->isNotEmpty();

        $finishDone =
            $saves->where('action', 'CONFIRM_KET_THUC_TOUR')->isNotEmpty();

        /*
        |--------------------------------------------------------------------------
        | HDV phụ trách
        |--------------------------------------------------------------------------
        */
        $guideIds = collect();

        if ($lichKhoiHanh->huong_dan_vien_id) {
            $guideIds->push((int) $lichKhoiHanh->huong_dan_vien_id);
        }

        $phanCong = PhanCong::where(
            'lich_khoi_hanh_id',
            $lichKhoiHanh->id
        )->first();

        if ($phanCong) {
            $ids = $phanCong->hdv_ids;

            if (is_string($ids)) {
                $decoded = json_decode($ids, true);
                $ids = is_array($decoded) ? $decoded : [];
            }

            foreach ((array) $ids as $id) {
                $guideIds->push((int) $id);
            }
        }

        $guides = HuongDanVien::whereIn(
            'id',
            $guideIds->unique()->values()
        )->get();

        /*
        |--------------------------------------------------------------------------
        | Build dữ liệu từng hoạt động
        |--------------------------------------------------------------------------
        */
        $activityData = [];

        foreach ($lichKhoiHanh->tour->lichTrinhTours as $ngay) {
            foreach ($ngay->chiTiets as $chiTiet) {
                $change = $scheduleChanges->get($chiTiet->id);

                $cancelled =
                    $change
                    && $change->loai_thay_doi === 'huy';

                $displayTitle =
                    $change && $change->tieu_de_moi
                    ? $change->tieu_de_moi
                    : $chiTiet->tieu_de;

                $displayStart =
                    $change && $change->gio_bat_dau_moi
                    ? $change->gio_bat_dau_moi
                    : $chiTiet->gio_bat_dau;

                $displayEnd =
                    $change && $change->gio_ket_thuc_moi
                    ? $change->gio_ket_thuc_moi
                    : $chiTiet->gio_ket_thuc;

                $activityRows = $allCheckIns
                    ->where('chi_tiet_lich_trinh_id', $chiTiet->id);

                $checkedInCount = $activityRows
                    ->whereIn(
                        'trang_thai',
                        ['da_check_in', 'da_check_out']
                    )
                    ->pluck('khach_hang_dat_tour_id')
                    ->unique()
                    ->count();

                $checkedOutCount = $activityRows
                    ->where('trang_thai', 'da_check_out')
                    ->pluck('khach_hang_dat_tour_id')
                    ->unique()
                    ->count();

                $checkInBuCount = $activityRows
                    ->where('is_checkin_bu', true)
                    ->count();

                $checkOutBuCount = $activityRows
                    ->where('is_checkout_bu', true)
                    ->count();

                if ($cancelled) {
                    $status = 'cancelled';
                } elseif (
                    $tongKhach > 0
                    && $checkedOutCount >= $tongKhach
                ) {
                    $status = 'completed';
                } elseif ($checkedInCount > 0) {
                    $status = 'checked_in';
                } else {
                    $status = 'pending';
                }

                $rowsByGuest = $activityRows
                    ->keyBy('khach_hang_dat_tour_id');

                $guestRows = $khachHangs->map(function ($khach) use ($rowsByGuest) {
                    $checkIn = $rowsByGuest->get($khach->id);

                    return [
                        'khach' => $khach,
                        'checkin' => $checkIn,
                        'trang_thai' => $checkIn
                            ? $checkIn->trang_thai
                            : 'chua_check_in',
                    ];
                });

                $activityData[$chiTiet->id] = [
                    'change' => $change,
                    'cancelled' => $cancelled,

                    'title' => $displayTitle,
                    'start' => $displayStart,
                    'end' => $displayEnd,

                    'status' => $status,

                    'checked_in_count' => $checkedInCount,
                    'checked_out_count' => $checkedOutCount,
                    'checkin_bu_count' => $checkInBuCount,
                    'checkout_bu_count' => $checkOutBuCount,

                    'guests' => $guestRows,
                ];
            }
        }

        return view('Admin.checkin_hdv.show', compact(
            'lichKhoiHanh',
            'datTours',
            'khachHangs',
            'tongKhach',
            'activityData',
            'departureDone',
            'finishDone',
            'guides'
        ));
    }
}
