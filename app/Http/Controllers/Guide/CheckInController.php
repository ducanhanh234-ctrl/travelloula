<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\CheckInKhachHang;
use App\Models\ChiTietLichTrinh;
use App\Models\DatTour;
use App\Models\HuongDanVien;
use App\Models\KhachHangDatTour;
use App\Models\LichKhoiHanhTour;
use App\Models\DiemDanhKhachHang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NhatKyHuongDanVien;


class CheckInController extends Controller
{
    public function index()
    {
        $guide = HuongDanVien::where('user_id', Auth::id())->firstOrFail();

        $today = now()->toDateString();

        $lichKhoiHanhs = LichKhoiHanhTour::with('tour')
            ->where('huong_dan_vien_id', $guide->id)
            // Ẩn tour đã kết thúc
            ->whereDate('ngay_ket_thuc', '>=', $today)
            // Tour đang diễn ra lên trước
            ->orderByRaw("
        CASE
            WHEN ? BETWEEN ngay_khoi_hanh AND ngay_ket_thuc THEN 0
            ELSE 1
        END
    ", [$today])
            ->orderBy('ngay_khoi_hanh')
            ->paginate(10);

        $tongTour = $lichKhoiHanhs->total();

        $dangDienRa = $lichKhoiHanhs->getCollection()
            ->where('ngay_khoi_hanh', '<=', now())
            ->where('ngay_ket_thuc', '>=', now())
            ->count();

        $sapKhoiHanh = $lichKhoiHanhs->getCollection()
            ->where('ngay_khoi_hanh', '>', now())
            ->count();

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
        $datTours = DatTour::with([
            'nguoiDung',
            'khachHangs'
        ])
            ->where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->get();

        $chiTiet = ChiTietLichTrinh::findOrFail($chiTietId);

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
                'checkIns'
            )
        );
    }

    public function checkIn(Request $request)
    {

        // Lấy hướng dẫn viên hiện tại
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();
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
    public function diaDiem($lichKhoiHanhId)
    {
        $lichKhoiHanh = LichKhoiHanhTour::with(
            'tour.lichTrinhTours.chiTiets'
        )->findOrFail($lichKhoiHanhId);

        return view(
            'Guide.checkin.diadiem',
            compact('lichKhoiHanh')
        );
    }

    public function diemDanh($lichKhoiHanhId, $ngayThu)
    {
        $datTours = DatTour::with([
            'nguoiDung',
            'khachHangs'
        ])
            ->where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->get();

        $tongKhach = 0;

        foreach ($datTours as $datTour) {
            $tongKhach += $datTour->khachHangs->count();
        }

        $diemDanhs = DiemDanhKhachHang::where(
            'lich_khoi_hanh_id',
            $lichKhoiHanhId
        )
            ->where('ngay_thu', $ngayThu)
            ->get()
            ->keyBy('khach_hang_dat_tour_id');

        return view(
            'Guide.checkin.diemdanh',
            compact(
                'datTours',
                'lichKhoiHanhId',
                'ngayThu',
                'tongKhach',
                'diemDanhs'
            )
        );
    }

    public function luuDiemDanh(Request $request)
    {
        
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

        $checkIn->thoi_gian_check_out = now();
        $checkIn->trang_thai = 'da_check_out';
        $checkIn->save();

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

        return back()->with(
            'success',
            'Check-out thành công.'
        );
    }

    public function checkInTatCa(Request $request)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $datTours = DatTour::with('khachHangs')
            ->where(
                'lich_khoi_hanh_id',
                $request->lich_khoi_hanh_id
            )
            ->get();

        $chiTiet = ChiTietLichTrinh::findOrFail(
            $request->chi_tiet_lich_trinh_id
        );

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
}
