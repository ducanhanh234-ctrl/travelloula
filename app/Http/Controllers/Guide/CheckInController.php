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
use App\Models\ThayDoiLichTrinh;

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
                ->where('action', 'CONFIRM_KET_THUC')
                ->exists();

            if (!$finished) {
                return redirect()
                    ->route('Guide.checkin.dia-diem', $lichKhoiHanhId)
                    ->with(
                        'error',
                        'Ngày ' . ($currentDay - 1) . ' chưa được chốt. Vui lòng hoàn tất điểm danh trước.'
                    );
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

                    if (!$prevConfirmed) {
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

        // $locked = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
        //     ->where('ngay_thu', $chiTiet->lichTrinh->ngay_thu)
        //     ->where('action', 'CONFIRM_KET_THUC')
        //     ->exists();

        $allCheckedOut = CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('chi_tiet_lich_trinh_id', $chiTietId)
            ->count() > 0
            &&
            !CheckInKhachHang::where('lich_khoi_hanh_id', $lichKhoiHanhId)
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
                // 'locked',
                'allCheckedOut'

            )
        );
    }

    protected function getActivityScheduleChange(
        LichKhoiHanhTour $lichKhoiHanh,
        ChiTietLichTrinh $chiTiet
    ): ?ThayDoiLichTrinh {
        return ThayDoiLichTrinh::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->first();
    }

    protected function getEffectiveActivitySchedule(
        LichKhoiHanhTour $lichKhoiHanh,
        ChiTietLichTrinh $chiTiet
    ): array {
        $change = $this->getActivityScheduleChange($lichKhoiHanh, $chiTiet);

        return [
            'change' => $change,
            'cancelled' => $change && $change->loai_thay_doi === 'huy',
            'title' => $change && $change->tieu_de_moi
                ? $change->tieu_de_moi
                : $chiTiet->tieu_de,
            'start_time' => $change && $change->gio_bat_dau_moi
                ? $change->gio_bat_dau_moi
                : $chiTiet->gio_bat_dau,
            'end_time' => $change && $change->gio_ket_thuc_moi
                ? $change->gio_ket_thuc_moi
                : $chiTiet->gio_ket_thuc,
        ];
    }

    protected function getScheduledStartAt(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        if (!$chiTiet->lichTrinh || !$chiTiet->lichTrinh->ngay_thu) {
            return null;
        }

        $effective = $this->getEffectiveActivitySchedule($lichKhoiHanh, $chiTiet);

        if ($effective['cancelled'] || !$effective['start_time']) {
            return null;
        }

        $date = Carbon::parse($lichKhoiHanh->ngay_khoi_hanh)
            ->addDays($chiTiet->lichTrinh->ngay_thu - 1)
            ->format('Y-m-d');

        try {
            return Carbon::parse($date . ' ' . $effective['start_time']);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getScheduledEndAt(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        if (!$chiTiet->lichTrinh || !$chiTiet->lichTrinh->ngay_thu) {
            return null;
        }

        $effective = $this->getEffectiveActivitySchedule($lichKhoiHanh, $chiTiet);

        if ($effective['cancelled'] || !$effective['end_time']) {
            return null;
        }

        $date = Carbon::parse($lichKhoiHanh->ngay_khoi_hanh)
            ->addDays($chiTiet->lichTrinh->ngay_thu - 1)
            ->format('Y-m-d');

        try {
            return Carbon::parse($date . ' ' . $effective['end_time']);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getCheckinWindow(
        LichKhoiHanhTour $lichKhoiHanh,
        ChiTietLichTrinh $chiTiet,
        bool $allowEarlyDeparture = false
    ) {
        $startAt = $this->getScheduledStartAt($lichKhoiHanh, $chiTiet);
        $endAt = $this->getScheduledEndAt($lichKhoiHanh, $chiTiet);

        if (!$startAt || !$endAt) {
            return [null, null];
        }

        // Check-in khởi hành
        if ($allowEarlyDeparture) {
            return [
                $startAt->copy()->subHour(), // trước 1 tiếng
                $startAt->copy(),             // đến giờ bắt đầu sự kiện 1
            ];
        }

        // Check-in hoạt động
        return [
            $startAt->copy(),
            $endAt->copy(),
        ];
    }

    protected function isCheckinWindowOpen(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet, bool $allowEarlyDeparture = false)
    {
        [$windowStart, $windowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet, $allowEarlyDeparture);
        if (!$windowStart || !$windowEnd) {
            return false;
        }

        $result = Carbon::now()->between($windowStart, $windowEnd);
        return $result;
    }

    protected function isCheckinWindowExpired(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet, bool $allowEarlyDeparture = false)
    {
        [$windowStart, $windowEnd] = $this->getCheckinWindow($lichKhoiHanh, $chiTiet, $allowEarlyDeparture);
        if (!$windowStart || !$windowEnd) {
            return false;
        }
        return Carbon::now()->gt($windowEnd);
    }

    protected function autoLockExpiredActivity(LichKhoiHanhTour $lichKhoiHanh, ChiTietLichTrinh $chiTiet)
    {
        $firstDayOneActivity = $this->getFirstDayOneActivity($lichKhoiHanh);
        $allowEarlyDeparture = $firstDayOneActivity && $firstDayOneActivity->id === $chiTiet->id;

        // if (!$this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet, $allowEarlyDeparture)) {
        //     return;
        // }
        $expired = $this->isCheckinWindowExpired(
            $lichKhoiHanh,
            $chiTiet,
            $allowEarlyDeparture
        );

        if (!$expired) {
            return;
        }

        if ($firstDayOneActivity && $chiTiet->id === $firstDayOneActivity->id) {
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

            return;
        }

        //                   dd([
        //     'chiTiet_id' => $chiTiet->id,
        //     'lichTrinh' => $chiTiet->lichTrinh,
        //     'ngay_thu' => $chiTiet->lichTrinh?->ngay_thu,
        // ]);
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
        $chiTiet = ChiTietLichTrinh::findOrFail($request->chi_tiet_lich_trinh_id);

        $firstDayOneActivity = $this->getFirstDayOneActivity($lichKhoiHanh);

        $allowEarlyDeparture =
            $firstDayOneActivity &&
            $firstDayOneActivity->id == $chiTiet->id;

        if (
            !$this->isCheckinWindowOpen(
                $lichKhoiHanh,
                $chiTiet,
                $allowEarlyDeparture
            )
        ) {
            return back()->with('error', 'Chưa đến giờ check-in hoặc đã quá giờ.');
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
            return back()->with('error', 'Khách đã check-in.');
        }

        if ($checkIn && $checkIn->trang_thai == 'da_check_out') {
            return back()->with('error', 'Khách đã check-out và không thể check-in lại.');
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
        $khach = KhachHangDatTour::findOrFail($request->khach_hang_dat_tour_id);
        $chiTiet = ChiTietLichTrinh::findOrFail($request->chi_tiet_lich_trinh_id);

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
        return back()->with(
            'success',
            'Check-in thành công.'
        );
    }
    public function checkInBu(Request $request)
    {
        $request->validate([
            'lich_khoi_hanh_id' => [
                'required',
                'integer',
                'exists:lich_khoi_hanh_tours,id',
            ],

            'chi_tiet_lich_trinh_id' => [
                'required',
                'integer',
                'exists:chi_tiet_lich_trinhs,id',
            ],

            'khach_hang_dat_tour_id' => [
                'required',
                'integer',
                'exists:khach_hang_dat_tours,id',
            ],

            'ly_do_checkin_bu' => [
                'required',
                'string',
                'max:500',
            ],
        ], [
            'ly_do_checkin_bu.required' =>
            'Vui lòng nhập lý do check-in bù.',
        ]);


        /*
    |--------------------------------------------------------------------------
    | 1. Lấy HDV đang đăng nhập
    |--------------------------------------------------------------------------
    */

        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | 2. Lấy lịch khởi hành và hoạt động
    |--------------------------------------------------------------------------
    */

        $lichKhoiHanh = LichKhoiHanhTour::findOrFail(
            $request->lich_khoi_hanh_id
        );

        $chiTiet = ChiTietLichTrinh::with('lichTrinh')
            ->findOrFail(
                $request->chi_tiet_lich_trinh_id
            );


        /*
    |--------------------------------------------------------------------------
    | 3. Kiểm tra HDV có được phân công tour này không
    |--------------------------------------------------------------------------
    */

        $assigned = false;

        if (
            $lichKhoiHanh->huong_dan_vien_id
            &&
            (int) $lichKhoiHanh->huong_dan_vien_id === (int) $guide->id
        ) {
            $assigned = true;
        } else {
            $assigned = PhanCong::where(
                'lich_khoi_hanh_id',
                $lichKhoiHanh->id
            )
                ->whereJsonContains(
                    'hdv_ids',
                    (string) $guide->id
                )
                ->exists();
        }

        if (!$assigned) {
            return back()->with(
                'error',
                'Bạn không có quyền điểm danh tour này.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | 4. Check-in bù CHỈ được dùng khi hoạt động đã hết giờ
    |--------------------------------------------------------------------------
    */

        if (
            !$this->isCheckinWindowExpired(
                $lichKhoiHanh,
                $chiTiet
            )
        ) {
            return back()->with(
                'error',
                'Hoạt động chưa kết thúc. Vui lòng sử dụng check-in thông thường.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | 5. Kiểm tra khách có thuộc lịch khởi hành này không
    |--------------------------------------------------------------------------
    */

        $khach = KhachHangDatTour::findOrFail(
            $request->khach_hang_dat_tour_id
        );

        $khachThuocTour = DatTour::where(
            'lich_khoi_hanh_id',
            $lichKhoiHanh->id
        )
            ->whereHas('khachHangs', function ($query) use ($khach) {
                $query->where(
                    'khach_hang_dat_tours.id',
                    $khach->id
                );
            })
            ->exists();

        if (!$khachThuocTour) {
            return back()->with(
                'error',
                'Khách hàng không thuộc lịch khởi hành này.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | 6. Tìm dữ liệu check-in của khách tại hoạt động
    |--------------------------------------------------------------------------
    */

        $checkIn = CheckInKhachHang::where(
            'khach_hang_dat_tour_id',
            $khach->id
        )
            ->where(
                'lich_khoi_hanh_id',
                $lichKhoiHanh->id
            )
            ->where(
                'chi_tiet_lich_trinh_id',
                $chiTiet->id
            )
            ->where(
                'checkin_context',
                'activity'
            )
            ->first();


        /*
    |--------------------------------------------------------------------------
    | 7. Nếu đã check-in/check-out rồi thì không cho check-in bù
    |--------------------------------------------------------------------------
    */

        if (
            $checkIn
            &&
            in_array(
                $checkIn->trang_thai,
                ['da_check_in', 'da_check_out'],
                true
            )
        ) {
            return back()->with(
                'error',
                'Khách này đã được điểm danh tại hoạt động.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | 8. Nếu chưa có record thì tạo
    |--------------------------------------------------------------------------
    */

        if (!$checkIn) {
            $checkIn = new CheckInKhachHang();

            $checkIn->khach_hang_dat_tour_id =
                $khach->id;

            $checkIn->lich_khoi_hanh_id =
                $lichKhoiHanh->id;

            $checkIn->chi_tiet_lich_trinh_id =
                $chiTiet->id;

            $checkIn->huong_dan_vien_id =
                $guide->id;

            $checkIn->checkin_context =
                'activity';
        }


        /*
    |--------------------------------------------------------------------------
    | 9. Lưu check-in bù
    |--------------------------------------------------------------------------
    */

        $checkIn->trang_thai = 'da_check_in';

        /*
     * Không back-date.
     *
     * Đây là thời điểm HDV thực sự thực hiện thao tác bù.
     */
        $checkIn->thoi_gian_check_in = now();

        $checkIn->thoi_gian_check_out = null;

        $checkIn->is_checkin_bu = true;

        $checkIn->ly_do_checkin_bu =
            trim($request->ly_do_checkin_bu);

        $checkIn->thoi_gian_ghi_nhan_bu =
            now();

        $checkIn->save();


        /*
    |--------------------------------------------------------------------------
    | 10. Ghi nhật ký HDV
    |--------------------------------------------------------------------------
    */

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' =>
            $lichKhoiHanh->id,

            'chi_tiet_lich_trinh_id' =>
            $chiTiet->id,

            'khach_hang_dat_tour_id' =>
            $khach->id,

            'huong_dan_vien_id' =>
            $guide->id,

            'hanh_dong' =>
            'CHECK_IN_BU',

            'noi_dung' =>
            'Check-in bù khách "' .
                $khach->ho_ten .
                '" tại hoạt động "' .
                $chiTiet->tieu_de .
                '". Lý do: ' .
                trim($request->ly_do_checkin_bu),
        ]);


        /*
    |--------------------------------------------------------------------------
    | 11. Trả về
    |--------------------------------------------------------------------------
    */

        return back()->with(
            'success',
            'Check-in bù khách "' .
                $khach->ho_ten .
                '" thành công.'
        );
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

        // Upsert into checkin_saves to persist saved state per (lich, chiTiet, action)
        try {
            CheckinSave::updateOrCreate(
                [
                    'lich_khoi_hanh_id' => $lich->id,
                    'chi_tiet_lich_trinh_id' => $request->chi_tiet_id ?? null,
                    'action' => $action,
                ],
                [
                    'ngay_thu' => $ngayThu,
                    'huong_dan_vien_id' => $guide->id,
                    'updated_at' => now(),
                ]
            );
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
        $departureDone = (bool) $lichKhoiHanh->da_checkin_khoi_hanh;
        $finishExpired = false;

        $tongKhach = DatTour::withCount('khachHangs')
            ->where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->get()
            ->sum('khach_hangs_count');

        if ($firstDayOneActivity) {
            [$departureWindowStart, $departureWindowEnd] =
                $this->getCheckinWindow($lichKhoiHanh, $firstDayOneActivity, true);

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
                $effective = $this->getEffectiveActivitySchedule($lichKhoiHanh, $chiTiet);

                if (!$effective['cancelled']) {
                    $this->autoLockExpiredActivity($lichKhoiHanh, $chiTiet);
                }

                [$windowStart, $windowEnd] = $this->getCheckinWindow(
                    $lichKhoiHanh,
                    $chiTiet,
                    false
                );

                $activityCheckIns = CheckInKhachHang::where(
                    'lich_khoi_hanh_id',
                    $lichKhoiHanh->id
                )
                    ->where('chi_tiet_lich_trinh_id', $chiTiet->id);

                $checkedInCount = (clone $activityCheckIns)
                    ->whereIn('trang_thai', ['da_check_in', 'da_check_out'])
                    ->count();

                $checkedOutCount = (clone $activityCheckIns)
                    ->where('trang_thai', 'da_check_out')
                    ->count();

                $hasCheckedIn = $checkedInCount > 0;

                $completed = $tongKhach > 0
                    && $checkedOutCount >= $tongKhach;

                if ($effective['cancelled']) {
                    $status = 'cancelled';
                    $completed = true;
                } elseif ($completed) {
                    $status = 'completed';
                } elseif ($hasCheckedIn) {
                    $status = 'checked_in';
                } else {
                    $status = 'pending';
                }

                $expired = $windowEnd
                    ? Carbon::now()->gt($windowEnd)
                    : false;

                $canCheckInByTime = $windowStart && $windowEnd
                    ? Carbon::now()->between($windowStart, $windowEnd)
                    : false;

                $canCheckIn = !$effective['cancelled']
                    && $canCheckInByTime
                    && !$hasCheckedIn
                    && !$completed;

                $canCheckInBu = !$effective['cancelled']
                    && $expired
                    && !$completed;

                $activityWindows[$chiTiet->id] = [
                    'can_checkin' => $canCheckIn,
                    'can_checkin_bu' => $canCheckInBu,
                    'expired' => $expired,

                    'status' => $status,
                    'has_checked_in' => $hasCheckedIn,
                    'completed' => $completed,

                    'checked_in_count' => $checkedInCount,
                    'checked_out_count' => $checkedOutCount,
                    'total_guests' => $tongKhach,

                    'schedule_change' => $effective['change'],
                    'cancelled' => $effective['cancelled'],
                    'display_title' => $effective['title'],
                    'display_start_time' => $effective['start_time'],
                    'display_end_time' => $effective['end_time'],

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

        $finishExpired = $finishEnd
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


    public function thayDoiLichTrinh(Request $request, $lichKhoiHanhId, $chiTietId)
    {
        $request->validate([
            'loai_thay_doi' => ['required', 'in:thay_the,doi_gio,huy'],
            'tieu_de_moi' => ['nullable', 'string', 'max:255'],
            'gio_bat_dau_moi' => ['nullable', 'date_format:H:i'],
            'gio_ket_thuc_moi' => ['nullable', 'date_format:H:i'],
            'ly_do' => ['required', 'string', 'max:1000'],
        ]);

        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($lichKhoiHanhId);
        $chiTiet = ChiTietLichTrinh::with('lichTrinh')->findOrFail($chiTietId);

        if (
            !$chiTiet->lichTrinh
            || (int) $chiTiet->lichTrinh->tour_id !== (int) $lichKhoiHanh->tour_id
        ) {
            return back()->with('error', 'Hoạt động không thuộc tour của lịch khởi hành này.');
        }

        $assigned = (
            $lichKhoiHanh->huong_dan_vien_id
            && (int) $lichKhoiHanh->huong_dan_vien_id === (int) $guide->id
        ) || PhanCong::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->whereJsonContains('hdv_ids', (string) $guide->id)
            ->exists();

        if (!$assigned) {
            return back()->with('error', 'Bạn không có quyền thay đổi lịch trình này.');
        }

        $loai = $request->loai_thay_doi;

        if ($loai === 'thay_the' && !$request->filled('tieu_de_moi')) {
            return back()->withInput()->with(
                'error',
                'Vui lòng nhập tên hoạt động thay thế.'
            );
        }

        $start = $request->gio_bat_dau_moi;
        $end = $request->gio_ket_thuc_moi;

        if ($start && $end && $end <= $start) {
            return back()->withInput()->with(
                'error',
                'Giờ kết thúc mới phải sau giờ bắt đầu mới.'
            );
        }

        $change = ThayDoiLichTrinh::updateOrCreate(
            [
                'lich_khoi_hanh_id' => $lichKhoiHanh->id,
                'chi_tiet_lich_trinh_id' => $chiTiet->id,
            ],
            [
                'huong_dan_vien_id' => $guide->id,
                'loai_thay_doi' => $loai,

                'tieu_de_moi' => $loai === 'huy'
                    ? null
                    : ($request->tieu_de_moi ?: $chiTiet->tieu_de),

                'gio_bat_dau_moi' => $loai === 'huy'
                    ? null
                    : ($start ?: $chiTiet->gio_bat_dau),

                'gio_ket_thuc_moi' => $loai === 'huy'
                    ? null
                    : ($end ?: $chiTiet->gio_ket_thuc),

                'ly_do' => trim($request->ly_do),
            ]
        );

        $moTa = match ($loai) {
            'huy' => 'Hủy hoạt động "' . $chiTiet->tieu_de . '"',
            'doi_gio' => 'Đổi giờ hoạt động "' . $chiTiet->tieu_de . '"',
            default => 'Thay hoạt động "' . $chiTiet->tieu_de . '" thành "' . $change->tieu_de_moi . '"',
        };

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $lichKhoiHanh->id,
            'chi_tiet_lich_trinh_id' => $chiTiet->id,
            'khach_hang_dat_tour_id' => null,
            'huong_dan_vien_id' => $guide->id,
            'hanh_dong' => 'THAY_DOI_LICH_TRINH',
            'noi_dung' => $moTa . '. Lý do: ' . trim($request->ly_do),
        ]);

        return back()->with('success', 'Đã cập nhật lịch trình thực tế của chuyến.');
    }

    public function khoiPhucLichTrinh($lichKhoiHanhId, $chiTietId)
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();
        $lichKhoiHanh = LichKhoiHanhTour::findOrFail($lichKhoiHanhId);
        $chiTiet = ChiTietLichTrinh::findOrFail($chiTietId);

        $assigned = (
            $lichKhoiHanh->huong_dan_vien_id
            && (int) $lichKhoiHanh->huong_dan_vien_id === (int) $guide->id
        ) || PhanCong::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->whereJsonContains('hdv_ids', (string) $guide->id)
            ->exists();

        if (!$assigned) {
            return back()->with('error', 'Bạn không có quyền khôi phục lịch trình này.');
        }

        $change = ThayDoiLichTrinh::where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->where('chi_tiet_lich_trinh_id', $chiTiet->id)
            ->first();

        if (!$change) {
            return back()->with('warning', 'Hoạt động này đang dùng lịch gốc.');
        }

        $oldReason = $change->ly_do;
        $change->delete();

        NhatKyHuongDanVien::create([
            'lich_khoi_hanh_id' => $lichKhoiHanh->id,
            'chi_tiet_lich_trinh_id' => $chiTiet->id,
            'khach_hang_dat_tour_id' => null,
            'huong_dan_vien_id' => $guide->id,
            'hanh_dong' => 'KHOI_PHUC_LICH_TRINH',
            'noi_dung' => 'Khôi phục hoạt động "' . $chiTiet->tieu_de .
                '" về lịch tour gốc. Lý do thay đổi trước đó: ' . $oldReason,
        ]);

        return back()->with('success', 'Đã khôi phục lịch trình gốc.');
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

        // $lichKhoiHanh = LichKhoiHanhTour::findOrFail($checkIn->lich_khoi_hanh_id);

        // $lichTrinhNgay1 = LichTrinhTour::where('tour_id', $lichKhoiHanh->tour_id)
        //     ->where('ngay_thu', 1)
        //     ->with('chiTiets')
        //     ->first();

        // $chiTiet = $lichTrinhNgay1->chiTiets->first();
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
        $allowEarlyDeparture =
            $firstDayOneActivity &&
            $chiTiet->id == $firstDayOneActivity->id;

        if (
            !$this->isCheckinWindowOpen(
                $lichKhoiHanh,
                $chiTiet,
                $allowEarlyDeparture
            )
        ) {
            return back()->with(
                'error',
                'Không thể check-in tất cả vì chưa đúng thời gian.'
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
            ->where('action', 'CONFIRM_XUATPHAT')
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

    public function showKetThuc(LichKhoiHanhTour $lichKhoiHanh)
    {
        // Lấy danh sách đặt tour và địa điểm ngày cuối cùng (hoạt động cuối)
        $datTours = DatTour::with('khachHangs')
            ->where('lich_khoi_hanh_id', $lichKhoiHanh->id)
            ->get();

        $lastLichTrinh = $lichKhoiHanh->tour->lichTrinhTours->sortBy('ngay_thu')->last();
        $chiTiet = null;

        if ($lastLichTrinh && $lastLichTrinh->chiTiets->isNotEmpty()) {
            // Lấy hoạt động cuối cùng của ngày cuối
            $chiTiet = $lastLichTrinh->chiTiets->sortBy('gio_ket_thuc')->last();
        }

        if (!$chiTiet) {
            return redirect()
                ->route('Guide.checkin.dia-diem', $lichKhoiHanh->id)
                ->with('error', 'Không có địa điểm để Check-in kết thúc tour. Vui lòng kiểm tra lịch trình.');
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
        $this->autoLockExpiredActivity($lichKhoiHanh, $chiTiet);
        $saved = CheckinSave::where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->where('action', 'CONFIRM_KET_THUC')
            ->exists();


        // Cửa sổ check-in cho kết thúc: từ gio_ket_thuc đến gio_ket_thuc + 30 phút
        [$checkinWindowStart, $checkinWindowEnd] =
            $this->getCheckinWindow($lichKhoiHanh, $chiTiet);

        $canCheckIn =
            $this->isCheckinWindowOpen($lichKhoiHanh, $chiTiet);

        $checkinExpired =
            $this->isCheckinWindowExpired($lichKhoiHanh, $chiTiet);
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
