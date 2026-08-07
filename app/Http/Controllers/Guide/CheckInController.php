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
        $lichKhoiHanhIds = PhanCong::whereJsonContains('hdv_ids', (string) $guide->id)
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
        // Kiểm tra CONFIRM_XUATPHAT chỉ dựa trên lich_khoi_hanh_id, không gắn với 1 chi_tiet_lich_trinh_id cụ thể
        // vì việc xuất phát chỉ được thực hiện 1 lần cho toàn bộ ngày 1
        if ($currentDay == 1) {
            $departureConfirmed = $lichKhoiHanh->da_checkin_khoi_hanh || CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
                ->where('action', 'CONFIRM_XUATPHAT')
                ->exists();

            if (!$departureConfirmed) {
                return redirect()
                    ->route('Guide.checkin.dia-diem', $lichKhoiHanhId)
                    ->with('error', 'Vui lòng thực hiện Check-in khởi hành (xuất phát) trước khi điểm danh hoạt động ngày 1.');
            }
        }

        // Nếu là ngày > 1 thì cần đảm bảo ngày trước đó đã hoàn tất (không còn trạng thái da_check_in)
        if ($currentDay > 1) {
            // $previous = LichTrinhTour::where('tour_id', $lichKhoiHanh->tour_id)
            //     ->where('ngay_thu', $currentDay - 1)
            //     ->with('chiTiets')
            //     ->first();

            // if ($previous && $previous->chiTiets->isNotEmpty()) {
            //     $prevIds = $previous->chiTiets->pluck('id')->toArray();

            //     $active = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            //         ->whereIn('chi_tiet_lich_trinh_id', $prevIds)
            //         ->where('trang_thai', 'da_check_in')
            //         ->exists();

            //     if ($active) {
            //         return redirect()
            //             ->route('Guide.checkin.dia-diem', $lichKhoiHanhId)
            //             ->with('error', 'Chưa hoàn tất Check-in/Check-out của ngày ' . ($currentDay - 1) . '. Vui lòng hoàn tất trước.');
            //     }
            // }

            $finished = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
                ->where('ngay_thu', $currentDay - 1)
                ->where('action', 'CONFIRM_KET_THUC_NGAY')
                ->exists();

            if (!$finished) {
                return redirect()
                    ->route('Guide.checkin.dia-diem', $lichKhoiHanhId)
                    ->with(
                        'error',
                        'Ngày ' . ($currentDay - 1) . ' chưa được chốt. Vui lòng hoàn tất điểm danh trước.'
                    );
            }
        }

        // Trong cùng một ngày, hoạt động sau chỉ được mở khi hoạt động trước đã được xác nhận.
        // Đặt ngoài điều kiện $currentDay > 1 để ngày 1 cũng áp dụng đúng.
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

                if (!$prevConfirmed) {
                    return redirect()
                        ->route('Guide.checkin.dia-diem', $lichKhoiHanhId)
                        ->with('error', 'Vui lòng hoàn tất điểm danh hoạt động trước đó trước khi điểm danh hoạt động này.');
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

        $checkedIds = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('checkin_context', 'activity')
            ->where(
                'chi_tiet_lich_trinh_id',
                $chiTietId
            )
            ->whereIn('trang_thai', [
                'da_check_in',
                'da_check_out'
            ])
            ->pluck('khach_hang_dat_tour_id')
            ->toArray();

        $checkIns = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('checkin_context', 'activity')
            ->where(
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

        // $locked = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
        //     ->where('ngay_thu', $chiTiet->lichTrinh->ngay_thu)
        //     ->where('action', 'CONFIRM_KET_THUC')
        //     ->exists();

        $allCheckedOut = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('checkin_context', 'activity')
            ->where('chi_tiet_lich_trinh_id', $chiTietId)
            ->count() > 0
            &&
            !CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
                ->where('checkin_context', 'activity')
                ->where('chi_tiet_lich_trinh_id', $chiTietId)
                ->where('trang_thai', '!=', 'da_check_out')
                ->exists();

        // dd([
        //     'allCheckedOut' => $allCheckedOut,
        //     'locked' => $locked,
        //     'tongKhach' => $tongKhach,
        //     'daCheck' => $daCheck,
        //     'checkout' => CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
        //         ->where('chi_tiet_lich_trinh_id', $chiTietId)
        //         ->pluck('trang_thai')
        //         ->toArray(),
        // ]);
        [$checkinWindowStart, $checkinWindowEnd] =
            $this->getCheckinWindow($lichKhoiHanh, $chiTietObj);

        $canCheckIn = $checkinWindowStart && $checkinWindowEnd
            ? now()->between($checkinWindowStart, $checkinWindowEnd)
            : false;

        $checkinExpired = $checkinWindowEnd
            ? now()->gt($checkinWindowEnd)
            : false;
        $checkinContext = 'activity';
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
                'checkinExpired',
                'checkinContext',
                // 'locked',
                'allCheckedOut'

            )
        );
    }

    protected function getScheduledStartAt(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        if (!$chiTiet->lichTrinh || !$chiTiet->lichTrinh->ngay_thu || !$chiTiet->gio_bat_dau) {
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

    protected function getScheduledEndAt(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        if (!$chiTiet->lichTrinh || !$chiTiet->lichTrinh->ngay_thu || !$chiTiet->gio_ket_thuc) {
            return null;
        }

        $date = Carbon::parse($lichKhoiHanh->ngay_khoi_hanh)
            ->addDays($chiTiet->lichTrinh->ngay_thu - 1)
            ->format('Y-m-d');

        try {
            return Carbon::parse($date . ' ' . $chiTiet->gio_ket_thuc);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Cửa sổ điểm danh của một hoạt động:
     * từ đúng giờ bắt đầu đến đúng giờ kết thúc hoạt động.
     */
    protected function getCheckinWindow(
        LichKhoiHanhTour $lichKhoiHanh,
        ChiTietLichTrinh $chiTiet
    ) {
        $startAt = $this->getScheduledStartAt($lichKhoiHanh, $chiTiet);
        $endAt = $this->getScheduledEndAt($lichKhoiHanh, $chiTiet);

        if (!$startAt || !$endAt) {
            return [null, null];
        }

        return [
            $startAt->copy(),
            $endAt->copy(),
        ];
    }

    /**
     * Cửa sổ check-in khởi hành:
     * từ 00:00 ngày khởi hành đến giờ bắt đầu hoạt động đầu tiên của ngày 1.
     */
    protected function getDepartureCheckinWindow(LichKhoiHanhTour $lichKhoiHanh)
    {
        $firstActivity = $this->getFirstDayOneActivity($lichKhoiHanh);
        if (!$firstActivity) {
            return [null, null];
        }

        $firstActivityStart = $this->getScheduledStartAt($lichKhoiHanh, $firstActivity);
        if (!$firstActivityStart) {
            return [null, null];
        }

        return [
            $firstActivityStart->copy()->startOfDay(),
            $firstActivityStart->copy(),
        ];
    }

    protected function isCheckinWindowOpen(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        [$windowStart, $windowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet);

        return $windowStart && $windowEnd
            ? Carbon::now()->between($windowStart, $windowEnd)
            : false;
    }

    protected function isCheckinWindowExpired(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        [, $windowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet);

        return $windowEnd
            ? Carbon::now()->gt($windowEnd)
            : false;
    }

    protected function isDepartureCheckinWindowOpen(LichKhoiHanhTour $lichKhoiHanh)
    {
        [$windowStart, $windowEnd] = $this->getDepartureCheckinWindow($lichKhoiHanh);

        return $windowStart && $windowEnd
            ? Carbon::now()->between($windowStart, $windowEnd)
            : false;
    }

    protected function isDepartureCheckinWindowExpired(LichKhoiHanhTour $lichKhoiHanh)
    {
        [, $windowEnd] = $this->getDepartureCheckinWindow($lichKhoiHanh);

        return $windowEnd
            ? Carbon::now()->gt($windowEnd)
            : false;
    }

    /**
     * Tách dữ liệu điểm danh theo từng ngữ cảnh để khởi hành không dùng chung
     * trạng thái với hoạt động đầu tiên và kết thúc không dùng chung hoạt động cuối.
     */
    protected function normalizeCheckinContext(?string $context): string
    {
        return in_array($context, ['departure', 'activity', 'finish'], true)
            ? $context
            : 'activity';
    }

    protected function isContextWindowOpen(
        LichKhoiHanhTour $lichKhoiHanh,
        ChiTietLichTrinh $chiTiet,
        string $context
    ): bool {
        $context = $this->normalizeCheckinContext($context);

        if ($context === 'departure') {
            return $this->isDepartureCheckinWindowOpen($lichKhoiHanh);
        }

        if ($context === 'finish') {
            [$start, $end] = $this->getFinishCheckinWindow($lichKhoiHanh);
            return $start && $end ? Carbon::now()->between($start, $end) : false;
        }

        return $this->isCheckinWindowOpen($lichKhoiHanh, $chiTiet);
    }

    protected function isContextWindowExpired(
        LichKhoiHanhTour $lichKhoiHanh,
        ChiTietLichTrinh $chiTiet,
        string $context
    ): bool {
        $context = $this->normalizeCheckinContext($context);

        if ($context === 'departure') {
            return $this->isDepartureCheckinWindowExpired($lichKhoiHanh);
        }

        if ($context === 'finish') {
            [, $end] = $this->getFinishCheckinWindow($lichKhoiHanh);
            return $end ? Carbon::now()->gt($end) : false;
        }

        return $this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet);
    }

    protected function contextMatchesActivity(
        LichKhoiHanhTour $lichKhoiHanh,
        ChiTietLichTrinh $chiTiet,
        string $context
    ): bool {
        if ($context === 'departure') {
            $first = $this->getFirstDayOneActivity($lichKhoiHanh);
            return $first && (int) $first->id === (int) $chiTiet->id;
        }

        if ($context === 'finish') {
            $last = $this->getLastDayLastActivity($lichKhoiHanh);
            return $last && (int) $last->id === (int) $chiTiet->id;
        }

        return true;
    }


    /**
     * Giữ hành vi auto-lock cũ nhưng tách khởi hành khỏi hoạt động.
     * Hoạt động đầu tiên sau khi hết giờ vẫn được CONFIRM_CHI_TIET như các hoạt động khác.
     */
    protected function autoLockExpiredActivity(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        if (!$this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet)) {
            return;
        }

        CheckinSave::updateOrCreate(
            [
                'lich_khoi_hanh_id' => $lichKhoiHanh->id,
                'chi_tiet_lich_trinh_id' => $chiTiet->id,
                'action' => 'CONFIRM_CHI_TIET',
            ],
            [
                'ngay_thu' => $chiTiet->lichTrinh->ngay_thu,
                'huong_dan_vien_id' => HuongDanVien::where('user_id', Auth::id())->value('id'),
            ]
        );

        $lastActivity = $this->getLastDayLastActivity($lichKhoiHanh);

        if ($lastActivity && $chiTiet->id === $lastActivity->id) {
            CheckinSave::updateOrCreate(
                [
                    'lich_khoi_hanh_id' => $lichKhoiHanh->id,
                    'action' => 'CONFIRM_KET_THUC_NGAY',
                    'ngay_thu' => $chiTiet->lichTrinh->ngay_thu,
                ],
                [
                    'huong_dan_vien_id' => HuongDanVien::where('user_id', Auth::id())->value('id'),
                ]
            );
        }
    }

    protected function autoLockExpiredDeparture(LichKhoiHanhTour $lichKhoiHanh)
    {
        if (!$this->isDepartureCheckinWindowExpired($lichKhoiHanh)) {
            return;
        }

        CheckinSave::updateOrCreate(
            [
                'lich_khoi_hanh_id' => $lichKhoiHanh->id,
                'action' => 'CONFIRM_XUATPHAT',
            ],
            [
                'chi_tiet_lich_trinh_id' => null,
                'ngay_thu' => 1,
                'huong_dan_vien_id' => HuongDanVien::where('user_id', Auth::id())->value('id'),
            ]
        );
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

    protected function getLastDayLastActivity(LichKhoiHanhTour $lichKhoiHanh)
    {
        // Lấy ngày cuối cùng của tour
        $lastDay = LichTrinhTour::where('tour_id', $lichKhoiHanh->tour_id)
            ->max('ngay_thu');

        if (!$lastDay) {
            return null;
        }

        // Lấy hoạt động cuối cùng của ngày cuối cùng (dựa trên gio_ket_thuc, sau đó gio_bat_dau)
        return ChiTietLichTrinh::whereHas('lichTrinh', function ($query) use ($lichKhoiHanh, $lastDay) {
            $query->where('tour_id', $lichKhoiHanh->tour_id)
                ->where('ngay_thu', $lastDay);
        })
            ->orderBy('gio_ket_thuc', 'desc')
            ->orderBy('gio_bat_dau', 'desc')
            ->first();
    }

    public function checkIn(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($request->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($request->input('checkin_context'));

        if (!$this->contextMatchesActivity($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Ngữ cảnh điểm danh không khớp với lịch trình.');
        }

        if (!$this->isContextWindowOpen($lichKhoiHanh, $chiTiet, $context)) {
            $message = match ($context) {
                'departure' => 'Check-in khởi hành chỉ được thực hiện từ 00:00 đến giờ bắt đầu hoạt động đầu tiên.',
                'finish' => 'Check-in kết thúc chỉ được thực hiện từ giờ kết thúc hoạt động cuối đến 23:59.',
                default => 'Hoạt động chỉ được điểm danh từ giờ bắt đầu đến giờ kết thúc.',
            };
            return back()->with('error', $message);
        }

        $checkIn = CheckInKhachHang::where('khach_hang_dat_tour_id', $request->khach_hang_dat_tour_id)
            ->where('lich_khoi_hanh_id', $request->lich_khoi_hanh_id)
            ->where('chi_tiet_lich_trinh_id', $request->chi_tiet_lich_trinh_id)
            ->where('checkin_context', $context)
            ->first();

        if ($checkIn && $checkIn->trang_thai === 'da_check_in') {
            return back()->with('error', 'Khách đã check-in.');
        }

        if ($checkIn && $checkIn->trang_thai === 'da_check_out') {
            return back()->with('error', 'Khách đã check-out và không thể check-in lại.');
        }

        if (!$checkIn) {
            $checkIn = new CheckInKhachHang();
            $checkIn->khach_hang_dat_tour_id = $request->khach_hang_dat_tour_id;
            $checkIn->lich_khoi_hanh_id = $request->lich_khoi_hanh_id;
            $checkIn->chi_tiet_lich_trinh_id = $request->chi_tiet_lich_trinh_id;
            $checkIn->huong_dan_vien_id = $guide->id;
            $checkIn->checkin_context = $context;
        }

        $checkIn->thoi_gian_check_in = now();
        $checkIn->thoi_gian_check_out = null;
        $checkIn->trang_thai = 'da_check_in';
        $checkIn->save();

        $khach = KhachHangDatTour::findOrFail($request->khach_hang_dat_tour_id);
        $contextLabel = match ($context) {
            'departure' => 'khởi hành',
            'finish' => 'kết thúc tour',
            default => $chiTiet->tieu_de,
        };

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $request->lich_khoi_hanh_id,
            'chi_tiet_lich_trinh_id' => $request->chi_tiet_lich_trinh_id,
            'khach_hang_dat_tour_id' => $khach->id,
            'huong_dan_vien_id' => $guide->id,
            'hanh_dong' => 'CHECK_IN',
            'noi_dung' => 'Check-in khách "' . $khach->ho_ten . '" tại "' . $contextLabel . '"',
        ]);

        return back()->with('success', 'Check-in thành công.');
    }

    /**
     * Persist the "saved" / confirmed departure state to the server.
     * This will mark the LichKhoiHanhTour->da_checkin_khoi_hanh = 1
     */
    public function saveLock(Request $request, $lichKhoiHanhId)
    {
        $ngayThu = $request->ngay_thu;
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lich = LichKhoiHanhTour::findOrFail($lichKhoiHanhId);

        // Check guide assignment: either huong_dan_vien_id or in PhanCong.hdv_ids
        $assigned = false;
        if ($lich->huong_dan_vien_id && $lich->huong_dan_vien_id == $guide->id) {
            $assigned = true;
        } else {
            $assigned = PhanCong::where('lich_khoi_hanh_id', $lich->id)
                ->whereJsonContains('hdv_ids', (string) $guide->id)
                ->exists();
        }

        if (!$assigned) {
            return response()->json([
                'success' => false,
                'message' => 'Không có quyền thực hiện.'
            ], 403);
        }

        // Do NOT update the global 'da_checkin_khoi_hanh' here.
        // Instead record a per-(lich,chiTiet) confirmation so other days are unaffected.
        $action = $request->action ?? 'CONFIRM_CHI_TIET';

        // Không chỉ khóa nút ở giao diện: luôn kiểm tra lại thời gian ở backend.
        if ($action === 'CONFIRM_XUATPHAT') {
            if (!$this->isDepartureCheckinWindowOpen($lich)) {
                return back()->with(
                    'error',
                    'Check-in khởi hành chỉ được xác nhận từ 00:00 đến giờ bắt đầu hoạt động đầu tiên.'
                );
            }
        }

        if ($action === 'CONFIRM_CHI_TIET') {
            $chiTietId = $request->chi_tiet_id;
            $chiTiet = $chiTietId ? ChiTietLichTrinh::with('lichTrinh')->find($chiTietId) : null;

            if (!$chiTiet || !$this->isCheckinWindowOpen($lich, $chiTiet)) {
                return back()->with(
                    'error',
                    'Chỉ được xác nhận hoạt động trong khoảng từ giờ bắt đầu đến giờ kết thúc.'
                );
            }
        }

        // Mỗi loại xác nhận có khóa riêng để không ghi đè dữ liệu của ngày/hoạt động khác.
        $lookup = [
            'lich_khoi_hanh_id' => $lich->id,
            'action' => $action,
        ];

        if ($action === 'CONFIRM_CHI_TIET') {
            $lookup['chi_tiet_lich_trinh_id'] = $request->chi_tiet_id;
        } elseif ($action === 'CONFIRM_KET_THUC_NGAY') {
            $lookup['ngay_thu'] = $ngayThu;
        } elseif ($action !== 'CONFIRM_XUATPHAT') {
            $lookup['chi_tiet_lich_trinh_id'] = $request->chi_tiet_id ?? null;
        }

        $values = [
            'ngay_thu' => $ngayThu,
            'huong_dan_vien_id' => $guide->id,
            'updated_at' => now(),
        ];

        if ($action === 'CONFIRM_XUATPHAT') {
            $values['chi_tiet_lich_trinh_id'] = null;
            $values['ngay_thu'] = 1;
        }

        try {
            CheckinSave::updateOrCreate($lookup, $values);
        } catch (\Exception $e) {
            // Unique constraint may conflict with concurrent requests; ignore duplicate insert errors
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

        if ($action === 'CONFIRM_KET_THUC_NGAY') {

            NhatKyHuongDanVien::create([
                'lich_khoi_hanh_id' => $lich->id,
                'chi_tiet_lich_trinh_id' => null,
                'khach_hang_dat_tour_id' => null,
                'huong_dan_vien_id' => $guide->id,
                'hanh_dong' => 'CONFIRM_KET_THUC_NGAY',
                'noi_dung' => 'Xác nhận chốt ngày thứ ' . $ngayThu,
            ]);

            return redirect()
                ->route('Guide.checkin.dia-diem', $lich->id)
                ->with('success', 'Đã chốt ngày thành công.');
        }
        // Also keep a human-readable log
        $noiDung = match ($action) {
            'CONFIRM_XUATPHAT'      => 'Xác nhận xuất phát.',
            'CONFIRM_CHI_TIET'      => 'Xác nhận hoàn tất điểm danh hoạt động.',
            'CONFIRM_KET_THUC_NGAY' => 'Xác nhận chốt ngày thứ ' . $ngayThu,
            default                 => $action,
        };

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $lich->id,
            'chi_tiet_lich_trinh_id' => $request->chi_tiet_id ?? null,
            'khach_hang_dat_tour_id' => null,
            'huong_dan_vien_id' => $guide->id,
            'hanh_dong' => $action,
            'noi_dung' => $noiDung,
        ]);

        // Nếu hành động là xác nhận điểm danh cho 1 địa điểm, kiểm tra xem tất cả
        // các chi tiết lịch trình của tour đã được xác nhận hay chưa. Nếu có, tạo
        // một bản ghi CONFIRM_KET_THUC và đánh dấu `da_checkin_khoi_hanh` để báo kết thúc.
        return redirect()
            ->route('Guide.checkin.dia-diem', $lich->id)
            ->with('success', 'Đã hoàn tất điểm danh.');
    }

    public function diaDiem($lichKhoiHanhId)
    {
        $lichKhoiHanh = LichKhoiHanhTour::with('tour.lichTrinhTours.chiTiets')
            ->findOrFail($lichKhoiHanhId);
        $activityWindows = [];
        $dayStatus = [];
        $firstDayOneActivity = $this->getFirstDayOneActivity($lichKhoiHanh);
        $departureCanCheckIn = false;
        $departureWindowStart = null;
        $departureWindowEnd = null;
        $finishCanCheckIn = false;

        if ($firstDayOneActivity) {
            $this->autoLockExpiredDeparture($lichKhoiHanh);
        }

        $departureDone = (bool) $lichKhoiHanh->da_checkin_khoi_hanh
            || CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
                ->where('action', 'CONFIRM_XUATPHAT')
                ->exists();

        $finishExpired = false;
        if ($firstDayOneActivity) {
            [$departureWindowStart, $departureWindowEnd] = $this->getDepartureCheckinWindow($lichKhoiHanh);
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
            $confirmedCount = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
                ->where('action', 'CONFIRM_CHI_TIET')
                ->where('ngay_thu', $ngay->ngay_thu)
                ->count();
            $dayStatus[$ngay->ngay_thu] = [
                'done' => $confirmedCount == $ngay->chiTiets->count(),

                'locked' => CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
                    ->where('action', 'CONFIRM_KET_THUC_NGAY')
                    ->where('ngay_thu', $ngay->ngay_thu)
                    ->exists(),
            ];

            foreach ($ngay->chiTiets as $chiTiet) {
                $this->autoLockExpiredActivity($lichKhoiHanh, $chiTiet);

                [$windowStart, $windowEnd] = $this->getCheckinWindow(
                    $lichKhoiHanh,
                    $chiTiet
                );

                $activityWindows[$chiTiet->id] = [
                    'can_checkin' => $windowStart && $windowEnd
                        ? now()->between($windowStart, $windowEnd)
                        : false,

                    'expired' => $windowEnd
                        ? now()->gt($windowEnd)
                        : false,

                    'starts_at' => $windowStart,
                    'ends_at' => $windowEnd,
                ];
            }
        }

        $lastActivity = $this->getLastDayLastActivity($lichKhoiHanh);

        $finishDone = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('action', 'CONFIRM_KET_THUC_TOUR')
            ->exists();

        $totalDays = $lichKhoiHanh->tour->lichTrinhTours->count();

        $lockedDays = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('action', 'CONFIRM_KET_THUC_NGAY')
            ->distinct('ngay_thu')
            ->count('ngay_thu');

        [$finishStart, $finishEnd] = $this->getFinishCheckinWindow($lichKhoiHanh);

        $finishCanCheckIn =
            $lockedDays === $totalDays
            && $finishStart
            && $finishEnd
            && now()->between($finishStart, $finishEnd);

        $finishExpired =
            $finishEnd
            ? now()->gt($finishEnd)
            : false;
        return view(
            'Guide.checkin.diadiem',
            compact(
                'lichKhoiHanh',
                'activityWindows',
                'departureCanCheckIn',
                'departureExpired',
                'departureWindowStart',
                'departureWindowEnd',
                'firstDayOneActivity',
                'finishCanCheckIn',
                'finishDone',
                'departureDone',
                'finishExpired',
                'lastActivity',
                'dayStatus'
            )
        );
    }


    public function checkOut($id)
    {
        $checkIn = CheckInKhachHang::findOrFail($id);

        if ($checkIn->thoi_gian_check_out !== null) {
            return back()->with('error', 'Khách đã check-out.');
        }

        if ($checkIn->trang_thai !== 'da_check_in') {
            return back()->with('error', 'Hành khách chưa check-in hoặc đã check-out.');
        }

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($checkIn->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($checkIn->checkin_context ?? 'activity');

        if (!$this->isContextWindowOpen($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Thời gian thao tác hiện không mở.');
        }

        $checkIn->thoi_gian_check_out = now();
        $checkIn->trang_thai = 'da_check_out';
        $checkIn->save();

        $khach = $checkIn->khachHang;
        $contextLabel = match ($context) {
            'departure' => 'khởi hành',
            'finish' => 'kết thúc tour',
            default => $chiTiet->tieu_de,
        };

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
            'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
            'khach_hang_dat_tour_id' => $khach->id,
            'huong_dan_vien_id' => $checkIn->huong_dan_vien_id,
            'hanh_dong' => 'CHECK_OUT',
            'noi_dung' => 'Check-out khách "' . $khach->ho_ten . '" tại "' . $contextLabel . '"',
        ]);

        return back()->with('success', 'Check-out thành công.');
    }


    public function checkInTatCa(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($request->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($request->input('checkin_context'));

        if (!$this->contextMatchesActivity($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Ngữ cảnh điểm danh không khớp với lịch trình.');
        }

        if (!$this->isContextWindowOpen($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Không thể check-in tất cả vì chưa đúng thời gian.');
        }

        $datTours = DatTour::with('khachHangs')
            ->where('lich_khoi_hanh_id', $request->lich_khoi_hanh_id)
            ->get();

        foreach ($datTours as $datTour) {
            foreach ($datTour->khachHangs as $khach) {
                $checkIn = CheckInKhachHang::where('khach_hang_dat_tour_id', $khach->id)
                    ->where('lich_khoi_hanh_id', $request->lich_khoi_hanh_id)
                    ->where('chi_tiet_lich_trinh_id', $request->chi_tiet_lich_trinh_id)
                    ->where('checkin_context', $context)
                    ->first();

                if ($checkIn && $checkIn->trang_thai === 'da_check_out') {
                    continue;
                }

                if (!$checkIn) {
                    $checkIn = new CheckInKhachHang();
                    $checkIn->khach_hang_dat_tour_id = $khach->id;
                    $checkIn->lich_khoi_hanh_id = $request->lich_khoi_hanh_id;
                    $checkIn->chi_tiet_lich_trinh_id = $request->chi_tiet_lich_trinh_id;
                    $checkIn->huong_dan_vien_id = $guide->id;
                    $checkIn->checkin_context = $context;
                }

                if ($checkIn->trang_thai !== 'da_check_in') {
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
                        'noi_dung' => 'Check-in khách "' . $khach->ho_ten . '".',
                    ]);
                }
            }
        }

        return back()->with('success', 'Đã check-in toàn bộ hành khách.');
    }

    public function checkOutTatCa(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($request->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($request->input('checkin_context'));

        if (!$this->contextMatchesActivity($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Ngữ cảnh điểm danh không khớp với lịch trình.');
        }

        if (!$this->isContextWindowOpen($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Thời gian thao tác hiện không mở.');
        }

        $checkIns = CheckInKhachHang::where('lich_khoi_hanh_id', $request->lich_khoi_hanh_id)
            ->where('chi_tiet_lich_trinh_id', $request->chi_tiet_lich_trinh_id)
            ->where('checkin_context', $context)
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
                'noi_dung' => 'Check-out khách "' . $checkIn->khachHang->ho_ten . '".',
            ]);
        }

        return back()->with('success', 'Đã check-out toàn bộ hành khách.');
    }


    //quay lại khi lỡ checkin
    public function undoCheckIn($id)
    {
        $checkIn = CheckInKhachHang::findOrFail($id);

        if ($checkIn->trang_thai !== 'da_check_in') {
            return back()->with('error', 'Không thể hoàn tác Check-in.');
        }

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($checkIn->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($checkIn->checkin_context ?? 'activity');

        if (!$this->isContextWindowOpen($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Thời gian thao tác hiện không mở.');
        }

        $checkIn->update([
            'trang_thai' => 'chua_check_in',
            'thoi_gian_check_in' => null,
            'thoi_gian_check_out' => null,
        ]);

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
            'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
            'khach_hang_dat_tour_id' => $checkIn->khach_hang_dat_tour_id,
            'huong_dan_vien_id' => $checkIn->huong_dan_vien_id,
            'hanh_dong' => 'UNDO_CHECK_IN',
            'noi_dung' => 'Hoàn tác Check-in khách "' . $checkIn->khachHang->ho_ten . '".',
        ]);

        return back()->with('success', 'Đã hoàn tác Check-in.');
    }

    public function undoCheckInTatCa(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($request->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($request->input('checkin_context'));

        if (!$this->isContextWindowOpen($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Thời gian thao tác hiện không mở.');
        }

        $checkIns = CheckInKhachHang::where('lich_khoi_hanh_id', $request->lich_khoi_hanh_id)
            ->where('chi_tiet_lich_trinh_id', $request->chi_tiet_lich_trinh_id)
            ->where('checkin_context', $context)
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
                'noi_dung' => 'Hoàn tác tất cả trạng thái Check-in/Check-out của hành khách "' . $checkIn->khachHang->ho_ten . '"',
            ]);
        }

        return back()->with('success', 'Đã hoàn tác tất cả hành khách về trạng thái chưa check-in.');
    }

    //quay lại khi lỡ check out
    public function undoCheckOut($id)
    {
        $checkIn = CheckInKhachHang::findOrFail($id);

        if ($checkIn->trang_thai !== 'da_check_out') {
            return back()->with('error', 'Không thể hoàn tác Check-out.');
        }

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($checkIn->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($checkIn->checkin_context ?? 'activity');

        if (!$this->isContextWindowOpen($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Thời gian thao tác hiện không mở.');
        }

        $checkIn->update([
            'trang_thai' => 'da_check_in',
            'thoi_gian_check_out' => null,
        ]);

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $checkIn->lich_khoi_hanh_id,
            'chi_tiet_lich_trinh_id' => $checkIn->chi_tiet_lich_trinh_id,
            'khach_hang_dat_tour_id' => $checkIn->khach_hang_dat_tour_id,
            'huong_dan_vien_id' => $checkIn->huong_dan_vien_id,
            'hanh_dong' => 'UNDO_CHECK_OUT',
            'noi_dung' => 'Hoàn tác Check-out khách "' . $checkIn->khachHang->ho_ten . '".',
        ]);

        return back()->with('success', 'Đã hoàn tác Check-out.');
    }

    public function saveNote(Request $request)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($request->lich_khoi_hanh_id);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($request->chi_tiet_lich_trinh_id);
        $context = $this->normalizeCheckinContext($request->input('checkin_context'));

        if ($this->isContextWindowExpired($lichKhoiHanh, $chiTiet, $context)) {
            return back()->with('error', 'Thời gian thao tác đã kết thúc.');
        }

        $checkIn = CheckInKhachHang::where('khach_hang_dat_tour_id', $request->khach_hang_dat_tour_id)
            ->where('lich_khoi_hanh_id', $request->lich_khoi_hanh_id)
            ->where('chi_tiet_lich_trinh_id', $request->chi_tiet_lich_trinh_id)
            ->where('checkin_context', $context)
            ->first();

        if (!$checkIn) {
            $checkIn = new CheckInKhachHang();
            $checkIn->khach_hang_dat_tour_id = $request->khach_hang_dat_tour_id;
            $checkIn->lich_khoi_hanh_id = $request->lich_khoi_hanh_id;
            $checkIn->chi_tiet_lich_trinh_id = $request->chi_tiet_lich_trinh_id;
            $checkIn->huong_dan_vien_id = $guide->id;
            $checkIn->checkin_context = $context;
            $checkIn->trang_thai = 'chua_check_in';
        }

        $checkIn->ghi_chu = $request->ghi_chu;
        $checkIn->save();

        return back()->with('success', 'Đã lưu ghi chú.');
    }
    public function showXuatPhat(LichKhoiHanhTour $lichKhoiHanh)
    {
        $lichKhoiHanh->load('tour.lichTrinhTours.chiTiets');

        $datTours = DatTour::with('khachHangs')
            ->where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->get();

        $chiTiet = $this->getFirstDayOneActivity($lichKhoiHanh);

        if (!$chiTiet) {
            return redirect()
                ->route('Guide.checkin.dia-diem', $lichKhoiHanh->id)
                ->with('error', 'Không có địa điểm để Check-in khởi hành. Vui lòng kiểm tra lịch trình.');
        }

        $checkedIds = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->where('checkin_context', 'departure')
            ->whereIn('trang_thai', ['da_check_in', 'da_check_out'])
            ->pluck('khach_hang_dat_tour_id')
            ->toArray();

        $checkIns = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->where('checkin_context', 'departure')
            ->get()
            ->keyBy('khach_hang_dat_tour_id');

        $tongKhach = $datTours->sum(fn ($datTour) => $datTour->khachHangs->count());
        $daCheck = count($checkedIds);
        $chuaCheck = max(0, $tongKhach - $daCheck);
        $lichKhoiHanhId = $lichKhoiHanh->id;

        $this->autoLockExpiredDeparture($lichKhoiHanh);

        $saved = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('action', 'CONFIRM_XUATPHAT')
            ->exists();

        [$checkinWindowStart, $checkinWindowEnd] = $this->getDepartureCheckinWindow($lichKhoiHanh);
        $canCheckIn = $this->isDepartureCheckinWindowOpen($lichKhoiHanh) && !$saved;
        $checkinExpired = $this->isDepartureCheckinWindowExpired($lichKhoiHanh);
        $checkinContext = 'departure';

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
            'checkinExpired',
            'checkinContext'
        ));
    }

    public function showKetThuc(LichKhoiHanhTour $lichKhoiHanh)
    {
        $lichKhoiHanh->load('tour.lichTrinhTours.chiTiets');

        $datTours = DatTour::with('khachHangs')
            ->where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->get();

        $chiTiet = $this->getLastDayLastActivity($lichKhoiHanh);

        if (!$chiTiet) {
            return redirect()
                ->route('Guide.checkin.dia-diem', $lichKhoiHanh->id)
                ->with('error', 'Không có địa điểm để Check-in kết thúc tour. Vui lòng kiểm tra lịch trình.');
        }

        $checkedIds = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->where('checkin_context', 'finish')
            ->whereIn('trang_thai', ['da_check_in', 'da_check_out'])
            ->pluck('khach_hang_dat_tour_id')
            ->toArray();

        $checkIns = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->where('checkin_context', 'finish')
            ->get()
            ->keyBy('khach_hang_dat_tour_id');

        $tongKhach = $datTours->sum(fn ($datTour) => $datTour->khachHangs->count());
        $daCheck = count($checkedIds);
        $chuaCheck = max(0, $tongKhach - $daCheck);
        $lichKhoiHanhId = $lichKhoiHanh->id;

        $saved = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('action', 'CONFIRM_KET_THUC_TOUR')
            ->exists();

        [$checkinWindowStart, $checkinWindowEnd] = $this->getFinishCheckinWindow($lichKhoiHanh);
        $canCheckIn = $checkinWindowStart && $checkinWindowEnd
            ? Carbon::now()->between($checkinWindowStart, $checkinWindowEnd) && !$saved
            : false;
        $checkinExpired = $checkinWindowEnd ? Carbon::now()->gt($checkinWindowEnd) : false;
        $checkinContext = 'finish';

        return view('Guide.checkin.ket_thuc', compact(
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
            'checkinExpired',
            'checkinContext'
        ));
    }

    // Khoảng thời gian check-in kết thúc tour.
    protected function getFinishCheckinWindow(LichKhoiHanhTour $lichKhoiHanh)
    {
        $lastActivity = $this->getLastDayLastActivity($lichKhoiHanh);
        if (!$lastActivity) {
            return [null, null];
        }
        $endAt = $this->getScheduledEndAt($lichKhoiHanh, $lastActivity);
        if (!$endAt) {
            return [null, null];
        }

        return [
            $endAt->copy(),
            $endAt->copy()->endOfDay(),
        ];
    }

    // public function storeKetThuc(Request $request, LichKhoiHanhTour $lichKhoiHanh)
    // {
    //     $guide = HuongDanVien::where('user_id', Auth::id())
    //         ->firstOrFail();

    //     CheckinSave::updateOrCreate(
    //         [
    //             'lich_khoi_hanh_id' => $lichKhoiHanh->id,
    //             'ngay_thu' => $request->ngay_thu,
    //             'action' => 'CONFIRM_KET_THUC_NGAY',
    //         ],
    //         [
    //             'huong_dan_vien_id' => $guide->id,
    //         ]
    //     );

    //     NhatKyHuongDanVien::create([
    //         'lich_khoi_hanh_id' => $lichKhoiHanh->id,
    //         'huong_dan_vien_id' => $guide->id,
    //         'hanh_dong' => 'CONFIRM_KET_THUC_NGAY',
    //         'noi_dung' => 'Xác nhận kết thúc ngày thứ ' . $request->ngay_thu,
    //     ]);

    //     return back()->with(
    //         'success',
    //         'Đã xác nhận kết thúc ngày.'
    //     );
    // }

    public function finishTour(Request $request, LichKhoiHanhTour $lichKhoiHanh)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())
            ->firstOrFail();

        $finished = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('action', 'CONFIRM_KET_THUC_TOUR')
            ->exists();

        if ($finished) {
            return back()->with(
                'warning',
                'Tour này đã được kết thúc trước đó.'
            );
        }

        [$finishStart, $finishEnd] = $this->getFinishCheckinWindow($lichKhoiHanh);
        if (!$finishStart || !$finishEnd || !Carbon::now()->between($finishStart, $finishEnd)) {
            return back()->with(
                'error',
                'Chỉ được xác nhận kết thúc tour từ khi hoạt động cuối kết thúc đến 23:59 của ngày cuối.'
            );
        }

        $totalDays = $lichKhoiHanh->tour->lichTrinhTours()->count();

        $lockedDays = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('action', 'CONFIRM_KET_THUC_NGAY')
            ->distinct('ngay_thu')
            ->count('ngay_thu');

        if ($lockedDays < $totalDays) {
            return back()->with(
                'error',
                'Vui lòng chốt tất cả các ngày trước khi kết thúc tour.'
            );
        }
        CheckinSave::updateOrCreate(
            [
                'lich_khoi_hanh_id' => $lichKhoiHanh->id,
                'action' => 'CONFIRM_KET_THUC_TOUR',
            ],
            [
                'huong_dan_vien_id' => $guide->id,
            ]
        );

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $lichKhoiHanh->id,
            'huong_dan_vien_id' => $guide->id,
            'hanh_dong' => 'CONFIRM_KET_THUC_TOUR',
            'noi_dung' => 'Xác nhận kết thúc tour.',
        ]);

        return back()->with('success', 'Đã kết thúc tour.');
    }
}
