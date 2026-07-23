<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\CheckInKhachHang;
use App\Models\ChiTietLichTrinh;
use App\Models\DatTour;
use App\Models\HuongDanVien;
use App\Models\KhachHangDatTour;
use App\Models\LichKhoiHanhTour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NhatKyHuongDanVien;
use App\Models\CheckinSave;
use App\Models\PhanCong;
use App\Models\LichTrinhTour;

class CheckInController extends Controller
{
    public function index()
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();

        // Lấy ID các lịch khởi hành mà HDV được phân công
        $lichKhoiHanhIds = PhanCong::whereJsonContains('hdv_ids', (string)$guide->id)
            ->pluck('lich_khoi_hanh_id');

        // Chỉ lấy lịch khởi hành đang diễn ra
        $lichKhoiHanhs = LichKhoiHanhTour::with('tour')
            ->whereIn('id', $lichKhoiHanhIds)
            ->where('trang_thai', 'running')
            ->orderBy('ngay_khoi_hanh')
            ->paginate(10);

        $tongTour = $lichKhoiHanhs->total();
        $dangDienRa = $tongTour;
        $sapKhoiHanh = 0;

        return view(
            'Guide.checkin.index',
            compact(
                'lichKhoiHanhs',
                'tongTour',
                'dangDienRa',
                'sapKhoiHanh'
            )
        );
    }

    public function show($lichKhoiHanhId, $chiTietId)
    {
        $lichKhoiHanh = LichKhoiHanhTour::with('tour')->findOrFail($lichKhoiHanhId);

        $chiTietObj = ChiTietLichTrinh::with('lichTrinh')->findOrFail($chiTietId);

        $currentDay = optional($chiTietObj->lichTrinh)->ngay_thu;

        // Nếu là ngày 1 thì phải đã check-in khởi hành (cho phép khi đã có ghi nhận xuất phát)
        if ($currentDay == 1) {
            $departureConfirmed = $lichKhoiHanh->da_checkin_khoi_hanh || CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
                ->where('chi_tiet_lich_trinh_id', $chiTietId)
                ->where('action', 'CONFIRM_XUATPHAT')
                ->exists();

            if (! $departureConfirmed) {
                return redirect()
                    ->route('Guide.checkin.dia-diem', $lichKhoiHanhId)
                    ->with('error', 'Vui lòng thực hiện Check-in khởi hành (xuất phát) trước khi điểm danh hoạt động ngày 1.');
            }
        }

        // Nếu là ngày > 1 thì cần đảm bảo ngày trước đó đã hoàn tất (không còn trạng thái da_check_in)
        if ($currentDay > 1) {
            $previous = LichTrinhTour::where('tour_id', $lichKhoiHanh->tour_id)
                ->where('ngay_thu', $currentDay - 1)
                ->with('chiTiets')
                ->first();

            if ($previous && $previous->chiTiets->isNotEmpty()) {
                $prevIds = $previous->chiTiets->pluck('id')->toArray();

                $active = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
                    ->whereIn('chi_tiet_lich_trinh_id', $prevIds)
                    ->where('trang_thai', 'da_check_in')
                    ->exists();

                if ($active) {
                    return redirect()
                        ->route('checkin.dia-diem', $lichKhoiHanhId)
                        ->with('error', 'Chưa hoàn tất Check-in/Check-out của ngày ' . ($currentDay - 1) . '. Vui lòng hoàn tất trước.');
                }
            }

            // Ngoài kiểm tra theo ngày, nếu trong cùng một ngày có nhiều hoạt động
            // thì chỉ cho phép điểm danh hoạt động hiện tại khi hoạt động trước đó
            // đã được xác nhận (CONFIRM_CHI_TIET).
            if (!empty($chiTietObj->thu_tu) && $chiTietObj->thu_tu > 1) {
                $previousThuTu = $chiTietObj->thu_tu - 1;
                $previous = ChiTietLichTrinh::where('lich_trinh_tour_id', $chiTietObj->lich_trinh_tour_id)
                    ->where('thu_tu', $previousThuTu)
                    ->first();

                if ($previous) {
                    $prevConfirmed = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
                        ->where('chi_tiet_lich_trinh_id', $previous->id)
                        ->where('action', 'CONFIRM_CHI_TIET')
                        ->exists();

                    if (! $prevConfirmed) {
                        return redirect()
                            ->route('Guide.checkin.dia-diem', $lichKhoiHanhId)
                            ->with('error', 'Vui lòng hoàn tất điểm danh hoạt động trước đó trước khi điểm danh hoạt động này.');
                    }
                }
            }
        }

        $this->autoLockExpiredActivity($lichKhoiHanh, $chiTietObj);

        $datTours = DatTour::with([
            'nguoiDung',
            'khachHangs'
        ])
            ->where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->get();

        $chiTiet = $chiTietObj;

        $checkedIds = CheckInKhachHang::where(
            'chi_tiet_lich_trinh_id',
            $chiTietId
        )
            ->whereIn('trang_thai', [
                'da_check_in',
                'da_check_out'
            ])
            ->pluck('khach_hang_dat_tour_id')
            ->toArray();

        $checkIns = CheckInKhachHang::where(
            'chi_tiet_lich_trinh_id',
            $chiTietId
        )
            ->get()
            ->keyBy('khach_hang_dat_tour_id');

        $tongKhach = 0;

        foreach ($datTours as $datTour) {
            $tongKhach += $datTour->khachHangs->count();
        }

        $daCheck = count($checkedIds);

        $chuaCheck = $tongKhach - $daCheck;
        // Server-side saved flag for this lich/chiTiet (from CheckinSave)
        $saved = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('chi_tiet_lich_trinh_id', $chiTietId)
            ->where('action', 'CONFIRM_CHI_TIET')
            ->exists();

        [$checkinWindowStart, $checkinWindowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet);
        $canCheckIn = $this->isCheckinWindowOpen($lichKhoiHanh, $chiTiet);
        $checkinExpired = $this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet);

        return view(
            'Guide.checkin.show',
            compact(
                'datTours',
                'chiTiet',
                'lichKhoiHanhId',
                'checkedIds',
                'tongKhach',
                'daCheck',
                'chuaCheck',
                'checkIns',
                'saved',
                'canCheckIn',
                'checkinWindowStart',
                'checkinWindowEnd',
                'checkinExpired'
            )
        );
    }

    protected function getScheduledStartAt(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        if (! $chiTiet->lichTrinh || ! $chiTiet->lichTrinh->ngay_thu || ! $chiTiet->gio_bat_dau) {
            return null;
        }

        $date = Carbon::parse($lichKhoiHanh->ngay_khoi_hanh)
            ->addDays($chiTiet->lichTrinh->ngay_thu - 1)
            ->format('Y-m-d');

        try {
            return Carbon::parse($date . ' ' . $chiTiet->gio_bat_dau);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getCheckinWindow(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet, bool $allowEarlyDeparture = false)
    {
        $startAt = $this->getScheduledStartAt($lichKhoiHanh, $chiTiet);

        if (! $startAt) {
            return [null, null];
        }

        $windowStart = $allowEarlyDeparture
            ? $startAt->copy()->subHours(2)
            : $startAt->copy();

        $windowEnd = $allowEarlyDeparture
            ? $startAt->copy()
            : $startAt->copy()->addMinutes(30);

        return [$windowStart, $windowEnd];
    }

    protected function isCheckinWindowOpen(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet, bool $allowEarlyDeparture = false)
    {
        [$windowStart, $windowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet, $allowEarlyDeparture);

        if (! $windowStart || ! $windowEnd) {
            return false;
        }

        return Carbon::now()->between($windowStart, $windowEnd);
    }

    protected function isCheckinWindowExpired(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet, bool $allowEarlyDeparture = false)
    {
        [$windowStart, $windowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet, $allowEarlyDeparture);

        if (! $windowStart || ! $windowEnd) {
            return false;
        }

        return Carbon::now()->gt($windowEnd);
    }

    protected function autoLockExpiredActivity(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        $firstDayOneActivity = $this->getFirstDayOneActivity($lichKhoiHanh);
        $allowEarlyDeparture = $firstDayOneActivity && $firstDayOneActivity->id === $chiTiet->id
            && ! $lichKhoiHanh->da_checkin_khoi_hanh;

        if (! $this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet, $allowEarlyDeparture)) {
            return;
        }

        if (CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->where('action', 'CONFIRM_CHI_TIET')
            ->exists()
        ) {
            return;
        }

        CheckinSave::updateOrCreate([
            'lich_khoi_hanh_id' => $lichKhoiHanh->id,
            'chi_tiet_lich_trinh_id' => $chiTiet->id,
            'action' => 'CONFIRM_CHI_TIET',
        ], [
            'lich_khoi_hanh_id' => $lichKhoiHanh->id,
            'chi_tiet_lich_trinh_id' => $chiTiet->id,
            'huong_dan_vien_id' => Auth::id() ? HuongDanVien::where('user_id', Auth::id())->value('id') : null,
            'action' => 'CONFIRM_CHI_TIET',
            'updated_at' => now(),
            'created_at' => now(),
        ]);
    }

    protected function getFirstDayOneActivity(LichKhoiHanhTour $lichKhoiHanh)
    {
        return ChiTietLichTrinh::whereHas('lichTrinh', function ($query) use ($lichKhoiHanh) {
            $query->where('tour_id', $lichKhoiHanh->tour_id)
                ->where('ngay_thu', 1);
        })
            ->orderBy('gio_bat_dau')
            ->first();
    }

    public function checkIn(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::findOrFail($request->chi_tiet_lich_trinh_id);

        $firstDayOneActivity = $this->getFirstDayOneActivity($lichKhoiHanh);
        $allowEarlyDeparture = $firstDayOneActivity && $firstDayOneActivity->id === $chiTiet->id
            && ! $lichKhoiHanh->da_checkin_khoi_hanh;

        if (! $this->isCheckinWindowOpen($lichKhoiHanh, $chiTiet, $allowEarlyDeparture)) {
            return back()->with(
                'error',
                'Chưa đến giờ check-in hoặc đã quá giờ check-in cho hoạt động này.'
            );
        }

        // Lấy hướng dẫn viên hiện tại
        $checkIn = CheckInKhachHang::where(
            'khach_hang_dat_tour_id',
            $request->khach_hang_dat_tour_id
        )
            ->where(
                'chi_tiet_lich_trinh_id',
                $request->chi_tiet_lich_trinh_id
            )
            ->first();

        if ($checkIn && $checkIn->trang_thai == 'da_check_in') {
            return back()->with(
                'error',
                'Khách đã check-in.'
            );
        }

        if ($checkIn && $checkIn->trang_thai == 'da_check_out') {
            return back()->with(
                'error',
                'Khách đã check-out và không thể check-in lại.'
            );
        }

        if (!$checkIn) {
            $checkIn = new CheckInKhachHang();

            $checkIn->khach_hang_dat_tour_id = $request->khach_hang_dat_tour_id;
            $checkIn->lich_khoi_hanh_id = $request->lich_khoi_hanh_id;
            $checkIn->chi_tiet_lich_trinh_id = $request->chi_tiet_lich_trinh_id;
            $checkIn->huong_dan_vien_id = $guide->id;
        }

        $checkIn->thoi_gian_check_in = now();
        $checkIn->thoi_gian_check_out = null;
        $checkIn->trang_thai = 'da_check_in';

        $checkIn->save();

        // Ghi nhật ký hướng dẫn viên
        $khach = KhachHangDatTour::findOrFail(
            $request->khach_hang_dat_tour_id
        );

        $chiTiet = ChiTietLichTrinh::findOrFail(
            $request->chi_tiet_lich_trinh_id
        );

        NhatKyHuongDanVien::create([

            'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,

            'chi_tiet_lich_trinh_id' => $request->chi_tiet_lich_trinh_id,

            'khach_hang_dat_tour_id' => $khach->id,

            'huong_dan_vien_id' => $guide->id,

            'hanh_dong' => 'CHECK_IN',

            'noi_dung' => 'Check-in khách "' .
                $khach->ho_ten .
                '" tại "' .
                $chiTiet->tieu_de .
                '"'

        ]);

        $khach = KhachHangDatTour::findOrFail(
            $request->khach_hang_dat_tour_id
        );
        return back()->with(
            'success',
            'Check-in thành công.'
        );
    }

    /**
     * Persist the "saved" / confirmed departure state to the server.
     * This will mark the LichKhoiHanhTour->da_checkin_khoi_hanh = 1
     */
    public function saveLock(Request $request, $lichKhoiHanhId)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();

        $lich = LichKhoiHanhTour::findOrFail($lichKhoiHanhId);

        // Check guide assignment: either huong_dan_vien_id or in PhanCong.hdv_ids
        $assigned = false;
        if ($lich->huong_dan_vien_id && $lich->huong_dan_vien_id == $guide->id) {
            $assigned = true;
        } else {
            $assigned = PhanCong::where('lich_khoi_hanh_id', $lich->id)
                ->whereJsonContains('hdv_ids', (string)$guide->id)
                ->exists();
        }

        if (! $assigned) {
            return response()->json([
                'success' => false,
                'message' => 'Không có quyền thực hiện.'
            ], 403);
        }

        // Do NOT update the global 'da_checkin_khoi_hanh' here.
        // Instead record a per-(lich,chiTiet) confirmation so other days are unaffected.
        $action = $request->action ?? 'CONFIRM_CHI_TIET';

        // Upsert into checkin_saves to persist saved state per (lich, chiTiet, action)
        $values = [
            'lich_khoi_hanh_id' => $lich->id,
            'chi_tiet_lich_trinh_id' => $request->chi_tiet_id ?? null,
            'huong_dan_vien_id' => $guide->id,
            'action' => $action,
            'updated_at' => now(),
            'created_at' => now(),
        ];

        try {
            CheckinSave::updateOrCreate([
                'lich_khoi_hanh_id' => $lich->id,
                'chi_tiet_lich_trinh_id' => $request->chi_tiet_id ?? null,
                'action' => $action,
            ], $values);
        } catch (\Exception $e) {
            // Unique constraint may conflict with concurrent requests; ignore duplicate insert errors
        }

        // Also keep a human-readable log
        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $lich->id,
            'chi_tiet_lich_trinh_id' => $request->chi_tiet_id ?? null,
            'khach_hang_dat_tour_id' => null,
            'huong_dan_vien_id' => $guide->id,
            'hanh_dong' => $action,
            'noi_dung' => $action === 'CONFIRM_XUATPHAT' ? 'Xác nhận xuất phát.' : 'Xác nhận điểm danh cho địa điểm.'
        ]);

        // Nếu hành động là xác nhận điểm danh cho 1 địa điểm, kiểm tra xem tất cả
        // các chi tiết lịch trình của tour đã được xác nhận hay chưa. Nếu có, tạo
        // một bản ghi CONFIRM_KET_THUC và đánh dấu `da_checkin_khoi_hanh` để báo kết thúc.
        if ($action === 'CONFIRM_CHI_TIET') {
            $allChiTietIds = ChiTietLichTrinh::whereHas('lichTrinh', function ($q) use ($lich) {
                $q->where('tour_id', $lich->tour_id);
            })->pluck('id')->toArray();

            $confirmedCount = CheckinSave::where('lich_khoi_hanh_id', $lich->id)
                ->where('action', 'CONFIRM_CHI_TIET')
                ->whereNotNull('chi_tiet_lich_trinh_id')
                ->whereIn('chi_tiet_lich_trinh_id', $allChiTietIds)
                ->distinct()
                ->count('chi_tiet_lich_trinh_id');

            if (count($allChiTietIds) > 0 && $confirmedCount >= count($allChiTietIds)) {
                try {
                    CheckinSave::updateOrCreate([
                        'lich_khoi_hanh_id' => $lich->id,
                        'chi_tiet_lich_trinh_id' => null,
                        'action' => 'CONFIRM_KET_THUC',
                    ], [
                        'lich_khoi_hanh_id' => $lich->id,
                        'chi_tiet_lich_trinh_id' => null,
                        'huong_dan_vien_id' => $guide->id,
                        'action' => 'CONFIRM_KET_THUC',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    // ignore unique/constraint errors
                }

                // Đánh dấu lịch là đã hoàn tất/khởi hành
                LichKhoiHanhTour::where('id', $lich->id)
                    ->update(['da_checkin_khoi_hanh' => 1]);

                NhatKyHuongDanVien::create([
                    'lich_khoi_hanh_id' => $lich->id,
                    'chi_tiet_lich_trinh_id' => null,
                    'khach_hang_dat_tour_id' => null,
                    'huong_dan_vien_id' => $guide->id,
                    'hanh_dong' => 'CONFIRM_KET_THUC',
                    'noi_dung' => 'Xác nhận kết thúc chuyến (đã điểm danh toàn bộ hoạt động).'
                ]);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }
    public function diaDiem($lichKhoiHanhId)
    {
        $lichKhoiHanh = LichKhoiHanhTour::with(
            'tour.lichTrinhTours.chiTiets'
        )->findOrFail($lichKhoiHanhId);

        $activityWindows = [];
        $firstDayOneActivity = $this->getFirstDayOneActivity($lichKhoiHanh);
        $departureCanCheckIn = false;
        $departureWindowStart = null;
        $departureWindowEnd = null;

        if ($firstDayOneActivity && ! $lichKhoiHanh->da_checkin_khoi_hanh) {
            [$departureWindowStart, $departureWindowEnd] = $this->getCheckinWindow($lichKhoiHanh, $firstDayOneActivity, true);
            $departureCanCheckIn = $departureWindowStart && $departureWindowEnd
                ? Carbon::now()->between($departureWindowStart, $departureWindowEnd)
                : false;
            $departureExpired = $departureWindowEnd
                ? Carbon::now()->gt($departureWindowEnd)
                : false;
        } else {
            $departureExpired = false;
        }

        foreach ($lichKhoiHanh->tour->lichTrinhTours as $ngay) {
            foreach ($ngay->chiTiets as $chiTiet) {
                $this->autoLockExpiredActivity($lichKhoiHanh, $chiTiet);
                [$windowStart, $windowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet);
                $activityWindows[$chiTiet->id] = [
                    'can_checkin' => $windowStart && $windowEnd
                        ? Carbon::now()->between($windowStart, $windowEnd)
                        : false,
                    'expired' => $windowEnd
                        ? Carbon::now()->gt($windowEnd)
                        : false,
                    'starts_at' => $windowStart,
                    'ends_at' => $windowEnd,
                ];
            }
        }

        return view(
            'Guide.checkin.diadiem',
            compact(
                'lichKhoiHanh',
                'activityWindows',
                'departureCanCheckIn',
                'departureExpired',
                'departureWindowStart',
                'departureWindowEnd',
                'firstDayOneActivity'
            )
        );
    }

    public function checkOut($id)
    {
        $checkIn = CheckInKhachHang::findOrFail($id);
        if ($checkIn->thoi_gian_check_out != null) {
            return back()->with(
                'error',
                'Khách đã check-out.'
            );
        }

        // Chỉ cho check-out nếu đã check-in
        if ($checkIn->trang_thai != 'da_check_in') {

            return back()->with(
                'error',
                'Hành khách chưa check-in hoặc đã check-out.'
            );
        }

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::findOrFail($checkIn->chi_tiet_lich_trinh_id);

        if ($this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet)) {
            return back()->with(
                'error',
                'Thời gian thao tác đã kết thúc.'
            );
        }

        $checkIn->thoi_gian_check_out = now();
        $checkIn->trang_thai = 'da_check_out';
        $checkIn->save();
        // Nếu đây là lần check-in đầu tiên của chuyến thì đánh dấu đã khởi hành
        // Kiểm tra còn ai chưa checkout không
        $conLai = CheckInKhachHang::where('lich_khoi_hanh_id', $checkIn->lich_khoi_hanh_id)
            ->where('chi_tiet_lich_trinh_id', $checkIn->chi_tiet_lich_trinh_id)
            ->where('trang_thai', '!=', 'da_check_out')
            ->exists();

        if (!$conLai) {
            LichKhoiHanhTour::where('id', $checkIn->lich_khoi_hanh_id)
                ->update([
                    'da_checkin_khoi_hanh' => 1
                ]);
        }
        $khach = $checkIn->khachHang;

        $chiTiet = ChiTietLichTrinh::findOrFail(
            $checkIn->chi_tiet_lich_trinh_id
        );

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
            'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
            'khach_hang_dat_tour_id' => $khach->id,
            'huong_dan_vien_id' => $checkIn->huong_dan_vien_id,
            'hanh_dong' => 'CHECK_OUT',
            'noi_dung' => 'Check-out khách "' .
                $khach->ho_ten .
                '" tại "' .
                $chiTiet->tieu_de .
                '"'
        ]);

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);

        $lichTrinhNgay1 = LichTrinhTour::where('tour_id', $lichKhoiHanh->tour_id)
            ->where('ngay_thu', 1)
            ->with('chiTiets')
            ->first();

        $chiTiet = $lichTrinhNgay1->chiTiets->first();
        return back()->with(
            'success',
            'Check-out thành công.'
        );
    }

    public function checkInTatCa(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::findOrFail($request->chi_tiet_lich_trinh_id);

        $firstDayOneActivity = $this->getFirstDayOneActivity($lichKhoiHanh);
        $allowEarlyDeparture = $firstDayOneActivity && $firstDayOneActivity->id === $chiTiet->id
            && ! $lichKhoiHanh->da_checkin_khoi_hanh;

        if (! $this->isCheckinWindowOpen($lichKhoiHanh, $chiTiet, $allowEarlyDeparture)) {
            return back()->with(
                'error',
                'Không thể check-in tất cả vì chưa đúng thời gian cho hoạt động này.'
            );
        }

        $datTours = DatTour::with('khachHangs')
            ->where(
                'lich_khoi_hanh_id',
                $request->lich_khoi_hanh_id
            )
            ->get();

        foreach ($datTours as $datTour) {
            foreach ($datTour->khachHangs as $khach) {
                $checkIn = CheckInKhachHang::where(
                    'khach_hang_dat_tour_id',
                    $khach->id
                )
                    ->where(
                        'chi_tiet_lich_trinh_id',
                        $request->chi_tiet_lich_trinh_id
                    )
                    ->first();

                if ($checkIn && $checkIn->trang_thai == 'da_check_out') {
                    continue;
                }

                if (!$checkIn) {
                    $checkIn = new CheckInKhachHang();
                    $checkIn->khach_hang_dat_tour_id = $khach->id;
                    $checkIn->lich_khoi_hanh_id = $request->lich_khoi_hanh_id;
                    $checkIn->chi_tiet_lich_trinh_id = $request->chi_tiet_lich_trinh_id;
                    $checkIn->huong_dan_vien_id = $guide->id;
                }

                if ($checkIn->trang_thai != 'da_check_in') {
                    $checkIn->thoi_gian_check_in = now();
                    $checkIn->thoi_gian_check_out = null;
                    $checkIn->trang_thai = 'da_check_in';
                    $checkIn->save();
                    NhatKyHuongDanVien::create([
                        'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,
                        'chi_tiet_lich_trinh_id' => $request->chi_tiet_lich_trinh_id,
                        'khach_hang_dat_tour_id' => $khach->id,
                        'huong_dan_vien_id' => $guide->id,
                        'hanh_dong' => 'CHECK_IN',
                        'noi_dung' => 'Check-in khách "' .
                            $khach->ho_ten .
                            '" tại "' .
                            $chiTiet->tieu_de .
                            '"'
                    ]);
                }
            }
        }
        return back()->with(
            'success',
            'Đã check-in toàn bộ hành khách.'
        );
    }

    public function checkOutTatCa(Request $request)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $chiTiet = ChiTietLichTrinh::findOrFail(
            $request->chi_tiet_lich_trinh_id
        );

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        if ($this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet)) {
            return back()->with(
                'error',
                'Thời gian thao tác đã kết thúc.'
            );
        }

        $checkIns = CheckInKhachHang::where(
            'chi_tiet_lich_trinh_id',
            $request->chi_tiet_lich_trinh_id
        )
            ->where('trang_thai', 'da_check_in')
            ->get();

        foreach ($checkIns as $checkIn) {
            $checkIn->update([
                'trang_thai' => 'da_check_out',
                'thoi_gian_check_out' => now(),
            ]);
            NhatKyHuongDanVien::create([
                'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
                'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
                'khach_hang_dat_tour_id' => $checkIn->khach_hang_dat_tour_id,
                'huong_dan_vien_id' => $guide->id,
                'hanh_dong' => 'CHECK_OUT',
                'noi_dung' => 'Check-out khách "' .
                    $checkIn->khachHang->ho_ten .
                    '" tại "' .
                    $chiTiet->tieu_de .
                    '"'
            ]);
        }
        // Sau khi tất cả đã checkout
        LichKhoiHanhTour::where(
            'id',
            $request->lich_khoi_hanh_id
        )->update([
            'da_checkin_khoi_hanh' => 1
        ]);
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);

        $lichTrinhNgay1 = LichTrinhTour::where('tour_id', $lichKhoiHanh->tour_id)
            ->where('ngay_thu', 1)
            ->with('chiTiets')
            ->first();

        $chiTiet = $lichTrinhNgay1->chiTiets->first();

        return back()->with(
            'success',
            'Đã check-out toàn bộ hành khách.'
        );
    }


    //quay lại khi lỡ checkin
    public function undoCheckIn($id)
    {
        $checkIn = CheckInKhachHang::findOrFail($id);

        // Chỉ hoàn tác khi đang ở trạng thái đã check-in
        if ($checkIn->trang_thai != 'da_check_in') {

            return back()->with(
                'error',
                'Không thể hoàn tác Check-in.'
            );
        }

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::findOrFail($checkIn->chi_tiet_lich_trinh_id);
        if ($this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet)) {
            return back()->with(
                'error',
                'Thời gian thao tác đã kết thúc.'
            );
        }

        // Đưa về trạng thái ban đầu
        $checkIn->update([
            'trang_thai' => 'chua_check_in',
            'thoi_gian_check_in' => null,
            'thoi_gian_check_out' => null,
        ]);

        // Lấy địa điểm
        $chiTiet = ChiTietLichTrinh::findOrFail(
            $checkIn->chi_tiet_lich_trinh_id
        );

        // Ghi nhật ký
        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
            'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
            'khach_hang_dat_tour_id' => $checkIn->khach_hang_dat_tour_id,
            'huong_dan_vien_id' => $checkIn->huong_dan_vien_id,
            'hanh_dong' => 'UNDO_CHECK_IN',
            'noi_dung' => 'Hoàn tác Check-in khách "' .
                $checkIn->khachHang->ho_ten .
                '" tại "' .
                $chiTiet->tieu_de .
                '"'

        ]);

        return back()->with(
            'success',
            'Đã hoàn tác Check-in.'
        );
    }

    public function undoCheckInTatCa(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();

        $chiTiet = ChiTietLichTrinh::findOrFail($request->chi_tiet_lich_trinh_id);
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        if ($this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet)) {
            return back()->with(
                'error',
                'Thời gian thao tác đã kết thúc.'
            );
        }

        $checkIns = CheckInKhachHang::where('lich_khoi_hanh_id', $request->lich_khoi_hanh_id)
            ->where('chi_tiet_lich_trinh_id', $request->chi_tiet_lich_trinh_id)
            ->whereIn('trang_thai', ['da_check_in', 'da_check_out'])
            ->get();

        foreach ($checkIns as $checkIn) {
            $checkIn->update([
                'trang_thai' => 'chua_check_in',
                'thoi_gian_check_in' => null,
                'thoi_gian_check_out' => null,
            ]);

            NhatKyHuongDanVien::create([
                'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
                'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
                'khach_hang_dat_tour_id' => $checkIn->khach_hang_dat_tour_id,
                'huong_dan_vien_id' => $guide->id,
                'hanh_dong' => 'UNDO_CHECKIN_ALL',
                'noi_dung' => 'Hoàn tác tất cả trạng thái Check-in/Check-out của hành khách "' . $checkIn->khachHang->ho_ten . '"'
            ]);
        }

        return back()->with(
            'success',
            'Đã hoàn tác tất cả hành khách về trạng thái chưa check-in.'
        );
    }

    //quay lại khi lỡ check out
    public function undoCheckOut($id)
    {
        $checkIn = CheckInKhachHang::findOrFail($id);

        // Chỉ hoàn tác khi đã check-out
        if ($checkIn->trang_thai != 'da_check_out') {

            return back()->with(
                'error',
                'Không thể hoàn tác Check-out.'
            );
        }

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::findOrFail($checkIn->chi_tiet_lich_trinh_id);
        if ($this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet)) {
            return back()->with(
                'error',
                'Thời gian thao tác đã kết thúc.'
            );
        }

        // Quay lại trạng thái đã check-in
        $checkIn->update([
            'trang_thai' => 'da_check_in',
            'thoi_gian_check_out' => null,
        ]);

        $chiTiet = ChiTietLichTrinh::findOrFail(
            $checkIn->chi_tiet_lich_trinh_id
        );

        // Ghi nhật ký
        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
            'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
            'khach_hang_dat_tour_id' => $checkIn->khach_hang_dat_tour_id,
            'huong_dan_vien_id' => $checkIn->huong_dan_vien_id,
            'hanh_dong' => 'UNDO_CHECK_OUT',
            'noi_dung' => 'Hoàn tác Check-out khách "' .
                $checkIn->khachHang->ho_ten .
                '" tại "' .
                $chiTiet->tieu_de .
                '"'

        ]);

        return back()->with(
            'success',
            'Đã hoàn tác Check-out.'
        );
    }

    public function saveNote(Request $request)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $checkIn = CheckInKhachHang::where(
            'khach_hang_dat_tour_id',
            $request->khach_hang_dat_tour_id
        )
            ->where(
                'lich_khoi_hanh_id',
                $request->lich_khoi_hanh_id
            )
            ->where(
                'chi_tiet_lich_trinh_id',
                $request->chi_tiet_lich_trinh_id
            )
            ->first();

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::findOrFail($request->chi_tiet_lich_trinh_id);
        if ($this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet)) {
            return back()->with(
                'error',
                'Thời gian thao tác đã kết thúc.'
            );
        }

        if (!$checkIn) {

            $checkIn = CheckInKhachHang::create([
                'khach_hang_dat_tour_id' => $request->khach_hang_dat_tour_id,
                'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,
                'chi_tiet_lich_trinh_id' => $request->chi_tiet_lich_trinh_id,
                'huong_dan_vien_id' => $guide->id,
                'trang_thai' => 'chua_check_in',
                'ghi_chu' => $request->ghi_chu,
            ]);
        } else {

            $checkIn->ghi_chu = $request->ghi_chu;
            $checkIn->save();
        }

        return back()->with(
            'success',
            'Đã lưu ghi chú.'
        );
    }
    public function showXuatPhat(LichKhoiHanhTour $lichKhoiHanh)
    {
        // Lấy danh sách đặt tour và địa điểm ngày 1 (sử dụng địa điểm đầu tiên của ngày 1)
        $datTours = DatTour::with('khachHangs')
            ->where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->get();

        $firstLichTrinh = $lichKhoiHanh->tour->lichTrinhTours->firstWhere('ngay_thu', 1);

        $chiTiet = null;

        if ($firstLichTrinh && $firstLichTrinh->chiTiets->isNotEmpty()) {
            $chiTiet = $firstLichTrinh->chiTiets->first();
        }

        if (!$chiTiet) {
            return redirect()
                ->route('Guide.checkin.dia-diem', $lichKhoiHanh->id)
                ->with('error', 'Không có địa điểm để Check-in khởi hành. Vui lòng kiểm tra lịch trình.');
        }

        $checkedIds = CheckInKhachHang::where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->whereIn('trang_thai', ['da_check_in', 'da_check_out'])
            ->pluck('khach_hang_dat_tour_id')
            ->toArray();

        $checkIns = CheckInKhachHang::where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->get()
            ->keyBy('khach_hang_dat_tour_id');

        $tongKhach = 0;
        foreach ($datTours as $datTour) {
            $tongKhach += $datTour->khachHangs->count();
        }

        $daCheck = count($checkedIds);
        $chuaCheck = $tongKhach - $daCheck;

        $lichKhoiHanhId = $lichKhoiHanh->id;

        // server-side saved flag for this lich/chiTiet (from CheckinSave)
        $saved = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->where('action', 'CONFIRM_CHI_TIET')
            ->exists();

        $this->autoLockExpiredActivity($lichKhoiHanh, $chiTiet);

        [$checkinWindowStart, $checkinWindowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet, true);
        $canCheckIn = $this->isCheckinWindowOpen($lichKhoiHanh, $chiTiet, true);
        $checkinExpired = $this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet, true);

        return view('Guide.checkin.xuat_phat', compact(
            'lichKhoiHanh',
            'datTours',
            'chiTiet',
            'checkedIds',
            'checkIns',
            'tongKhach',
            'daCheck',
            'chuaCheck',
            'lichKhoiHanhId',
            'saved',
            'canCheckIn',
            'checkinWindowStart',
            'checkinWindowEnd',
            'checkinExpired'
        ));
    }
}
