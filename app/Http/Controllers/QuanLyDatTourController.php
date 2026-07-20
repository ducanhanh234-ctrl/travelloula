<?php

namespace App\Http\Controllers;

use App\Models\DatTour;
use App\Models\HuongDanVien;
use App\Models\LichKhoiHanhTour;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\KhachHangDatTour;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ThanhToan;
use Illuminate\Support\Facades\Log;

class QuanLyDatTourController extends Controller
{

    // Hiển thị danh sách đặt tour
    public function index(Request $request)
    {
        $query = DatTour::with([
            'tour',
            'nguoiDung',
            'lichKhoiHanh.huongDanVien'
        ]);

        // Tìm kiếm
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ma_dat_tour', 'like', "%$keyword%")
                    ->orWhereHas('tour', function ($tour) use ($keyword) {
                        $tour->where(
                            'ten_tour',
                            'like',
                            "%$keyword%"
                        );
                    });
            });
        }

        // Lọc trạng thái
        if ($request->status) {
            $query->where(
                'trang_thai',
                $request->status
            );
        }
        $bookings = $query
            ->latest('ngay_dat')
            ->paginate(10)
            ->withQueryString();

        // Thống kê
        $totalBookings = DatTour::count();
        $websiteBookings = 0;
        $saleBookings = 0;
        $revenue = number_format(
            DatTour::sum('tong_tien'),
            0,
            ',',
            '.'
        ) . ' đ';
        $statuses = [
            'cho_xac_nhan' => 'Chờ xác nhận',
            'da_xac_nhan' => 'Đã xác nhận',
            'da_thanh_toan' => 'Đã thanh toán',
            'da_huy' => 'Đã hủy',
            'hoan_thanh' => 'Hoàn thành',
        ];

        $filters = [
            'keyword' => $request->keyword,
            'status' => $request->status
        ];
        $huongDanViens = HuongDanVien::where('trang_thai', 'hoat_dong')->get();
        return view(
            'Admin.quan_ly_dat_tours.index',
            compact(
                'bookings',
                'totalBookings',
                'websiteBookings',
                'saleBookings',
                'revenue',
                'statuses',
                'filters'
            )
        );
    }

    // Đổi hướng dẫn viên
    public function updateHDV(Request $request, $id)
    {
        $request->validate([
            'huong_dan_vien_id' => 'required'
        ]);
        $booking = DatTour::findOrFail($id);
        $oldTotal =
            $booking->so_nguoi_lon +
            $booking->so_tre_em +
            $booking->so_em_be;

        $newTotal =
            $request->so_nguoi_lon +
            $request->so_tre_em +
            $request->so_em_be;

        $diff = $newTotal - $oldTotal;

        //         dd([
        //     'oldTotal' => $oldTotal,
        //     'newTotal' => $newTotal,
        //     'diff' => $diff,

        //     'adult_request' => $request->so_nguoi_lon,
        //     'child_request' => $request->so_tre_em,
        //     'baby_request' => $request->so_em_be,

        //     'delete_ids' => $request->hanh_khach_xoa,
        // ]);

        if ($booking->lichKhoiHanh) {
            if ($diff > 0) {
                // thêm khách -> trừ chỗ
                $booking->lichKhoiHanh->update([
                    'so_cho_con_lai' =>
                    $booking->lichKhoiHanh->so_cho_con_lai - $diff,
                    'so_cho_da_dat' =>
                    $booking->lichKhoiHanh->so_cho_da_dat + $diff
                ]);
            }
            if ($diff < 0) {
                // giảm khách -> trả chỗ
                $booking->lichKhoiHanh->update([
                    'so_cho_con_lai' =>
                    $booking->lichKhoiHanh->so_cho_con_lai + abs($diff),
                    'so_cho_da_dat' =>
                    $booking->lichKhoiHanh->so_cho_da_dat - abs($diff)
                ]);
            }
        }
        if ($booking->lichKhoiHanh) {
            $booking->lichKhoiHanh->update([
                'huong_dan_vien_id' => $request->huong_dan_vien_id
            ]);
        }
        return back()->with(
            'success',
            'Đã đổi hướng dẫn viên'
        );
    }

    // Hủy tour
    public function huyTour($id)
    {
        $datTour = DatTour::findOrFail($id);
        $datTour->update([
            'trang_thai' => 'da_huy'
        ]);

        $lich = $datTour->lichKhoiHanh;
        if ($lich) {
            $tongKhach =
                $datTour->so_nguoi_lon +
                $datTour->so_tre_em +
                $datTour->so_em_be;
            $lich->update([
                'so_cho_con_lai' =>
                $lich->so_cho_con_lai + $tongKhach,
                'so_cho_da_dat' =>
                max(
                    0,
                    $lich->so_cho_da_dat - $tongKhach
                )
            ]);
        }

        return back()->with(
            'success',
            'Đã hủy tour'
        );
    }

    // Form thêm booking thủ công
    public function create()
    {
        $user = Auth::user();
        $tours = Tour::with('lichTrinh')->get();
        $users = User::orderBy('name')->get();

        return view(
            'Admin.quan_ly_dat_tours.create',
            compact(
                'tours',
                'user',
                'users'
            )
        );
    }

    // Lưu booking thủ công
    public function store(Request $request)
    {

        // Validate phải có ít nhất 1 người lớn
        if ((int) $request->so_nguoi_lon < 1) {
            return back()
                ->withInput()
                ->withErrors([
                    'so_nguoi_lon' => 'Booking phải có ít nhất 1 người lớn.'
                ]);
        }

        DB::beginTransaction();
        try {
            // $request->validate([
            //     'tour_id' => 'required|exists:tours,id',
            //     'lich_khoi_hanh' => [
            //         'required',
            //         'date',
            //         'after_or_equal:today'
            //     ],
            // ]);
            $tour = Tour::with('lichTrinh')
                ->findOrFail($request->tour_id);
            $tongKhach =
                (int) $request->so_nguoi_lon +
                (int) $request->so_tre_em +
                (int) $request->so_em_be;

            $soNguoiLon = (int) $request->so_nguoi_lon;
            $soTreEm = (int) $request->so_tre_em;
            $soEmBe = (int) $request->so_em_be;

            $tongTien =
                ($soNguoiLon * $tour->gia_nguoi_lon) +
                ($soTreEm * $tour->gia_tre_em) +
                ($soEmBe * $tour->gia_em_be);

            $lichKhoiHanh = LichKhoiHanhTour::where('id', $request->lich_khoi_hanh_id)
                ->where('tour_id', $request->tour_id)
                ->firstOrFail();

            // Kiểm tra số chỗ còn lại
            if ($lichKhoiHanh->so_cho_con_lai < $tongKhach) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Lịch khởi hành không đủ chỗ trống'
                    );
            }

            // Tạo booking
            $datTour = DatTour::create([
                'tour_id' => $request->tour_id,
                'nguoi_dung_id' => Auth::id(),
                'lich_khoi_hanh_id' => $lichKhoiHanh->id,
                'ma_dat_tour' =>
                'BK' . strtoupper(Str::random(6)),
                'so_nguoi_lon' => $soNguoiLon,
                'so_tre_em' => $soTreEm,
                'so_em_be' => $soEmBe,

                'tong_tien' => $tongTien,
                'so_tien_da_thanh_toan' =>
                $request->so_tien_da_thanh_toan ?? 0,
                'trang_thai' => $request->trang_thai,
                'ghi_chu' => $request->ghi_chu,
                'ngay_dat' => now(),
            ]);

            // Trừ số chỗ
            $lichKhoiHanh->update([
                'so_cho_con_lai' =>
                $lichKhoiHanh->so_cho_con_lai - $tongKhach,
                'so_cho_da_dat' =>
                $lichKhoiHanh->so_cho_da_dat + $tongKhach,
            ]);

            // Nếu hết chỗ thì chuyển trạng thái full
            if ($lichKhoiHanh->fresh()->so_cho_con_lai <= 0) {
                $lichKhoiHanh->update([
                    'trang_thai' => 'full'
                ]);
            }

            // Lưu hành khách
            if ($request->hanh_khach) {
                foreach ($request->hanh_khach as $khach) {
                    KhachHangDatTour::create([
                        'dat_tour_id' => $datTour->id,

                        'ho_ten' =>
                        $khach['ho_ten']
                            ?? 'Chưa nhập',

                        'gioi_tinh' =>
                        $khach['gioi_tinh']
                            ?? null,

                        'nam_sinh' =>
                        $khach['nam_sinh']
                            ?? null,

                        'ngay_sinh' =>
                        $khach['ngay_sinh']
                            ?? null,

                        'quoc_tich' =>
                        $khach['quoc_tich']
                            ?? 'Việt Nam',

                        'loai_giay_to' => $khach['loai_giay_to'] ?? 'CCCD',

                        'so_giay_to' => $khach['so_giay_to'] ?? null,

                        'so_dien_thoai' =>
                        $khach['so_dien_thoai']
                            ?? null,

                        'yeu_cau_dac_biet' =>
                        $khach['yeu_cau_dac_biet']
                            ?? null,

                        'loai_hanh_khach' =>
                        $khach['loai_hanh_khach']
                            ?? 'adult',

                        'trang_thai_thanh_toan'
                        => 'pending',

                        'tong_tien' => 0,

                        'so_tien_da_thanh_toan'
                        => 0,
                    ]);
                }
            }


            // Tạo thanh toán cho đặt tour
            ThanhToan::create([
                'dat_tour_id' => $datTour->id,
                'nguoi_dung_id' => Auth::id(),
                'phuong_thuc_thanh_toan' =>
                $request->phuong_thuc_thanh_toan,

                'so_tien' =>
                $request->so_tien_da_thanh_toan
                    ?? 0,
                'ma_giao_dich' => 'GD' . strtoupper(Str::random(8)),
                'trang_thai' => ($request->so_tien_da_thanh_toan > 0)
                    ? 'da_thanh_toan'
                    : 'cho_thanh_toan',
                'ghi_chu' =>
                'Thanh toán tạo từ quản lý đặt tour',
                'thoi_gian_thanh_toan' => now(),
            ]);
            DB::commit();
            return redirect()
                ->route(
                    'Admin.quan_ly_dat_tour.index'
                )
                ->with(
                    'success',
                    'Thêm booking thủ công thành công'
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    // Hiển thị chi tiết đặt tour
    public function show($id)
    {
        $booking = DatTour::with([
            'tour',
            'tour.danhMuc',
            'lichKhoiHanh',
            'tour.lichTrinh',
            'nguoiDung',
            'khachHangDatTour',
            'thanhToans'
        ])->findOrFail($id);

        return view('Admin.quan_ly_dat_tours.show', compact('booking'));
    }

    //xóa mềm
    public function destroy($id)
    {
        $booking = DatTour::findOrFail($id);
        if ($booking->trang_thai !== 'da_huy') {
            $tongKhach =
                $booking->so_nguoi_lon +
                $booking->so_tre_em +
                $booking->so_em_be;
            if ($booking->lichKhoiHanh) {
                $booking->lichKhoiHanh->update([
                    'so_cho_con_lai' =>
                    $booking->lichKhoiHanh->so_cho_con_lai
                        + $tongKhach,
                    'so_cho_da_dat' =>
                    max(
                        0,
                        $booking->lichKhoiHanh->so_cho_da_dat
                            - $tongKhach
                    ),
                    'trang_thai' => 'available'
                ]);
            }
        }
        $booking->delete();
        return back()->with(
            'success',
            'Đã chuyển booking vào thùng rác.'
        );
    }

    //xóa cứng
    public function forceDelete($id)
    {
        $booking = DatTour::withTrashed()
            ->findOrFail($id);

        $booking->forceDelete();

        return back()->with(
            'success',
            'Đã xóa vĩnh viễn booking.'
        );
    }

    //khôi phục
    public function restore($id)
    {
        $booking = DatTour::withTrashed()
            ->findOrFail($id);
        $tongKhach =
            $booking->so_nguoi_lon +
            $booking->so_tre_em +
            $booking->so_em_be;
        if ($booking->lichKhoiHanh) {
            if (
                $booking->lichKhoiHanh->so_cho_con_lai
                < $tongKhach
            ) {
                return back()->with(
                    'error',
                    'Không đủ chỗ để khôi phục booking'
                );
            }
            $booking->lichKhoiHanh->update([
                'so_cho_con_lai' =>
                $booking->lichKhoiHanh->so_cho_con_lai
                    - $tongKhach,
                'so_cho_da_dat' =>
                $booking->lichKhoiHanh->so_cho_da_dat
                    + $tongKhach,
            ]);
        }
        $booking->restore();
        return back()->with(
            'success',
            'Khôi phục booking thành công.'
        );
    }

    // Thùng rác
    public function trash()
    {
        $bookings = DatTour::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view(
            'Admin.quan_ly_dat_tours.trash',
            compact('bookings')
        );
    }

    // Lấy danh sách lịch khởi hành theo tour
    public function getLichKhoiHanhByTour($tourId)
    {
        $lichs = LichKhoiHanhTour::where('tour_id', $tourId)
            ->get();
        $data = $lichs->map(function ($lich) {
            return [
                'id' => $lich->id,
                'ngay_khoi_hanh' => $lich->ngay_khoi_hanh,
                'ngay_ket_thuc' => $lich->ngay_ket_thuc,
                'so_cho_con_lai' => $lich->so_cho_con_lai,
                'so_cho_da_dat' => $lich->so_cho_da_dat,
                'is_full' => $lich->so_cho_con_lai <= 0,
            ];
        });
        return response()->json($data);
    }

    // Sửa đặt tour
    public function edit($id)
    {
        $booking = DatTour::with([
            'tour',
            'lichKhoiHanh',
            'khachHangDatTour',
            'thanhToans',
            'nguoiDung'
        ])->findOrFail($id);
        $tours = Tour::with('lichTrinh')->get();
        $payment = $booking->thanhToans->first();
        $hanhKhachs = $booking->khachHangDatTour;
        return view(
            'Admin.quan_ly_dat_tours.edit',
            compact(
                'booking',
                'tours',
                'payment',
                'hanhKhachs'
            )
        );
    }

    // Cập nhật đặt tour
    public function update(Request $request, $id)
    {
        //tránh nhập số âm
        $request->validate([
            'so_nguoi_lon' => 'required|integer|min:0',
            'so_tre_em' => 'required|integer|min:0',
            'so_em_be' => 'required|integer|min:0',
        ]);
        $booking = DatTour::findOrFail($id);
        $oldTotal =
            $booking->so_nguoi_lon +
            $booking->so_tre_em +
            $booking->so_em_be;

        $newTotal =
            (int)$request->so_nguoi_lon +
            (int)$request->so_tre_em +
            (int)$request->so_em_be;
        $tour = Tour::findOrFail($request->tour_id);
        $diff = $newTotal - $oldTotal;

        if ($diff > 0 && $booking->lichKhoiHanh->so_cho_con_lai < $diff) {
            return back()
                ->withInput()
                ->with('error', 'Lịch khởi hành không đủ chỗ trống.');
        }

        $tongTien =
            ($request->so_nguoi_lon * $tour->gia_nguoi_lon) +
            ($request->so_tre_em * $tour->gia_tre_em) +
            ($request->so_em_be * $tour->gia_em_be);

        $booking->update([
            'tour_id' => $request->tour_id,
            // 'so_nguoi_lon' => $request->so_nguoi_lon,
            // 'so_tre_em' => $request->so_tre_em,
            // 'so_em_be' => $request->so_em_be,
            'tong_tien' => $tongTien,
            'so_tien_da_thanh_toan'
            => $request->so_tien_da_thanh_toan,
            'trang_thai' => $request->trang_thai,
            'ghi_chu' => $request->ghi_chu,
        ]);

        // cập nhật thanh toán đầu tiên
        $payment = $booking->thanhToans()->first();
        if ($payment) {
            $payment->update([
                'so_tien' => $request->so_tien_da_thanh_toan,
                'trang_thai' =>
                $request->so_tien_da_thanh_toan >= $tongTien
                    ? 'da_thanh_toan'
                    : 'cho_thanh_toan'
            ]);
        }

        // xóa hành khách khi giảm số lượng
        if ($request->has('hanh_khach_xoa')) {
            foreach ($request->hanh_khach_xoa as $id) {
                $khach = KhachHangDatTour::find($id);
                if ($khach) {
                    $khach->delete();
                }
            }
        }

        // cập nhật hành khách cũ
        if ($request->has('hanh_khach')) {
            foreach ($request->hanh_khach as $hk) {
                if (!empty($hk['id'])) {
                    KhachHangDatTour::where('id', $hk['id'])
                        ->update([
                            'ho_ten' => $hk['ho_ten'] ?? null,
                            'gioi_tinh' => $hk['gioi_tinh'] ?? null,
                            'ngay_sinh' => $hk['ngay_sinh'] ?? null,
                            'quoc_tich' => $hk['quoc_tich'] ?? null,
                            'loai_giay_to' => $hk['loai_giay_to'] ?? null,
                            'so_giay_to' => $hk['so_giay_to'] ?? null,
                            'so_dien_thoai' => $hk['so_dien_thoai'] ?? null,
                            'yeu_cau_dac_biet' => $hk['yeu_cau_dac_biet'] ?? null,
                        ]);
                }
            }
        }

        // thêm hành khách mới
        if ($request->has('hanh_khach_moi')) {
            foreach ($request->hanh_khach_moi as $hk) {
                if (!empty($hk['ho_ten'])) {
                    KhachHangDatTour::create([
                        'dat_tour_id' => $booking->id,
                        'ho_ten' => $hk['ho_ten'],
                        'gioi_tinh' => $hk['gioi_tinh'] ?? null,
                        'ngay_sinh' => $hk['ngay_sinh'] ?? null,
                        'quoc_tich' => $hk['quoc_tich'] ?? null,
                        'loai_giay_to' => $hk['loai_giay_to'] ?? null,
                        'so_giay_to' => $hk['so_giay_to'] ?? null,
                        'so_dien_thoai' => $hk['so_dien_thoai'] ?? null,
                        'yeu_cau_dac_biet' => $hk['yeu_cau_dac_biet'] ?? null,
                        'loai_hanh_khach' => $hk['loai_hanh_khach'],
                    ]);
                }
            }
        }

        $booking->update([
            'so_nguoi_lon' => $booking->khachHangs()
                ->where('loai_hanh_khach', 'adult')
                ->count(),

            'so_tre_em' => $booking->khachHangs()
                ->where('loai_hanh_khach', 'child')
                ->count(),

            'so_em_be' => $booking->khachHangs()
                ->where('loai_hanh_khach', 'baby')
                ->count(),
        ]);

        if ($booking->lichKhoiHanh) {
            $booking->lichKhoiHanh->update([
                'ngay_khoi_hanh' => $request->ngay_khoi_hanh,
                'ngay_ket_thuc' => $request->ngay_ket_thuc,

                'so_cho_da_dat' => $booking->lichKhoiHanh->so_cho_da_dat + $diff,
                'so_cho_con_lai' => $booking->lichKhoiHanh->so_cho_con_lai - $diff,
            ]);
        }

        //         dd([
        //     'request_adult' => $request->so_nguoi_lon,
        //     'request_child' => $request->so_tre_em,
        //     'request_baby' => $request->so_em_be,

        //     'booking_adult' => $booking->so_nguoi_lon,
        //     'booking_child' => $booking->so_tre_em,
        //     'booking_baby' => $booking->so_em_be,
        // ]);

        return redirect()
            ->route('Admin.dat_tours.show', $booking->id)
            ->with(
                'success',
                'Cập nhật booking thành công'
            );
    }
    public function create_dat_tour($tourId)
    {
        $tour = Tour::findOrFail($tourId);
        $tours = Tour::all();
        $lichKhoiHanhs = LichKhoiHanhTour::where('tour_id', $tourId)
        ->whereIn('trang_thai', ['available', 'closed', 'full'])
            ->orderBy('ngay_khoi_hanh')
            ->get();
        $lichDuocChon = [
            'gia_nguoi_lon' => $tour->gia_nguoi_lon,
            'tong_tien' => ($tour->gia_nguoi_lon + $tour->gia_tre_em + $tour->gia_em_be),
        ];
        return view('client.dat_tour.index', compact(
            'tour',
            'lichKhoiHanhs',
            'lichDuocChon',
            'tours'
        ));
    }

    public function store_dat_tour(Request $request)
    {
        $request->validate([

    'tour_id' => 'required|exists:danh_sach_tours,id',

    'lich_khoi_hanh_id' => 'required|exists:lich_khoi_hanh_tours,id',

    'so_nguoi_lon' => 'required|integer|min:1',

    'so_tre_em' => 'nullable|integer|min:0',

    'so_em_be' => 'nullable|integer|min:0',

    'phuong_thuc_thanh_toan' => 'required',

    'hanh_khach' => 'required|array|min:1',

    // Họ tên
    'hanh_khach.*.ho_ten' => [
        'required',
        'string',
        'min:2',
        'max:100'
    ],

    // Giới tính
    'hanh_khach.*.gioi_tinh' => [
        'required',
        'in:Nam,Nữ'
    ],

    // Ngày sinh
    'hanh_khach.*.ngay_sinh' => [
        'required',
        'date',
        'before:today'
    ],

    // Quốc tịch
    'hanh_khach.*.quoc_tich' => [
        'required',
        'string',
        'max:100'
    ],

    // Loại hành khách
    'hanh_khach.*.loai_hanh_khach' => [
        'required',
        'in:adult,child,baby'
    ],

    // Loại giấy tờ
    'hanh_khach.*.loai_giay_to' => [
        'required',
        'in:CCCD,Hộ chiếu,Giấy khai sinh'
    ],

    // Số giấy tờ
    'hanh_khach.*.so_giay_to' => [
        'required',
        'string',
        'max:30'
    ],

    // Điện thoại
    'hanh_khach.*.so_dien_thoai' => [
        'nullable',
        'regex:/^(0|\+84)[0-9]{9,10}$/'
    ],

    'hanh_khach.*.yeu_cau_dac_biet' => [
        'nullable',
        'max:500'
    ],

]);

        DB::beginTransaction();

        try {

            // Khóa bản ghi lịch khởi hành để tránh nhiều người đặt cùng lúc
            $lich = LichKhoiHanhTour::lockForUpdate()
                ->findOrFail($request->lich_khoi_hanh_id);
// Chỉ cho phép đặt khi lịch đang mở bán
if ($lich->trang_thai !== 'available') {

    DB::rollBack();

    return back()
        ->withInput()
        ->with('error', 'Lịch khởi hành này hiện không mở bán.');
}
            $tour = Tour::findOrFail($request->tour_id);

            $soNguoiLon = (int) $request->so_nguoi_lon;
            $soTreEm    = (int) ($request->so_tre_em ?? 0);
            $soEmBe     = (int) ($request->so_em_be ?? 0);

            $tongKhach = $soNguoiLon + $soTreEm + $soEmBe;
// Kiểm tra số lượng hành khách nhập có khớp không
if (count($request->hanh_khach) != $tongKhach) {

    DB::rollBack();

    return back()
        ->withInput()
        ->with('error', 'Số lượng hành khách không khớp với số lượng đã chọn.');
}

// Kiểm tra tuổi và giấy tờ của từng hành khách
foreach ($request->hanh_khach as $hk) {

    $tuoi = \Carbon\Carbon::parse($hk['ngay_sinh'])->age;

    switch ($hk['loai_hanh_khach']) {

        case 'adult':

            if ($tuoi < 12) {
                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('error', 'Người lớn phải từ 12 tuổi trở lên.');
            }

            break;

        case 'child':

            if ($tuoi < 2 || $tuoi > 11) {
                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('error', 'Trẻ em phải từ 2 đến 11 tuổi.');
            }

            break;
    }

    // Kiểm tra CCCD
    if (
        $hk['loai_giay_to'] == 'CCCD' &&
        !preg_match('/^[0-9]{12}$/', $hk['so_giay_to'])
    ) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', 'CCCD phải gồm đúng 12 chữ số.');
    }
}
            // Kiểm tra số chỗ còn lại
            if ($lich->so_cho_con_lai < $tongKhach) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('error', 'Lịch khởi hành không còn đủ chỗ.');
            }

            // Tính tổng tiền từ dữ liệu tour
            $tongTien =
                ($soNguoiLon * $tour->gia_nguoi_lon) +
                ($soTreEm * $tour->gia_tre_em) +
                ($soEmBe * $tour->gia_em_be);

            // Sinh mã đặt tour
            do {
                $maDatTour = 'ATU' . strtoupper(Str::random(8));
            } while (DatTour::where('ma_dat_tour', $maDatTour)->exists());

            //==========================
            // Tạo đơn đặt tour
            //==========================
            $booking = DatTour::create([

                'nguoi_dung_id' => Auth::id(),

                'tour_id' => $tour->id,

                'lich_khoi_hanh_id' => $lich->id,

                'ma_dat_tour' => $maDatTour,

                'so_nguoi_lon' => $soNguoiLon,

                'so_tre_em' => $soTreEm,

                'so_em_be' => $soEmBe,

                'tong_tien' => $tongTien,

                'so_tien_da_thanh_toan' => 0,

                'trang_thai' => 'cho_xac_nhan',

                'ghi_chu' => $request->ghi_chu,

                'ngay_dat' => now(),
            ]);

            //==========================
            // Lưu hành khách
            //==========================
            foreach ($request->hanh_khach as $hk) {

                KhachHangDatTour::create([

                    'dat_tour_id' => $booking->id,

                    'ho_ten' => $hk['ho_ten'],

                    'gioi_tinh' => $hk['gioi_tinh'] ?? null,

                    'ngay_sinh' => $hk['ngay_sinh'] ?? null,

                    'nam_sinh' => $hk['nam_sinh'] ?? null,

                    'quoc_tich' => $hk['quoc_tich'] ?? 'Việt Nam',

                    'loai_hanh_khach' => $hk['loai_hanh_khach'] ?? 'adult',

                    'loai_giay_to' => $hk['loai_giay_to'] ?? 'CCCD',

                    'so_giay_to' => $hk['so_giay_to'] ?? null,

                    'so_dien_thoai' => $hk['so_dien_thoai'] ?? null,

                    'yeu_cau_dac_biet' => $hk['yeu_cau_dac_biet'] ?? null,

                    'trang_thai_thanh_toan' => 'pending',

                    'tong_tien' => 0,

                    'so_tien_da_thanh_toan' => 0,
                ]);
            }

            //==========================
            // Tạo bản ghi thanh toán
            //==========================
            ThanhToan::create([

                'dat_tour_id' => $booking->id,

                'nguoi_dung_id' => Auth::id(),

                'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,

                'so_tien' => $tongTien,

                // Sẽ cập nhật sau khi tạo URL VNPay
                'ma_giao_dich' => null,

                'trang_thai' => 'cho_thanh_toan',

                'ghi_chu' => 'Khởi tạo giao dịch.',

                'thoi_gian_thanh_toan' => null,
            ]);

            //==========================
            // Cập nhật số chỗ
            //==========================
            $lich->decrement('so_cho_con_lai', $tongKhach);

            $lich->increment('so_cho_da_dat', $tongKhach);

            // Nếu đã hết chỗ thì chuyển trạng thái
            if ($lich->fresh()->so_cho_con_lai <= 0) {

                $lich->update([
                    'trang_thai' => 'full'
                ]);
            }

            DB::commit();

            //==========================
            // Chuyển sang VNPay
            //==========================
            if ($request->phuong_thuc_thanh_toan == 'VNPAY') {

                return redirect()->route(
                    'vnpay.payment',
                    $booking->id
                );
            }

            // Thanh toán tiền mặt
            return redirect()
                ->route('Client.home')
                ->with(
                    'success',
                    'Đặt tour thành công. Vui lòng thanh toán khi nhận dịch vụ.'
                );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
