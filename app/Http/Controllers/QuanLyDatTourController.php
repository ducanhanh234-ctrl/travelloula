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

class QuanLyDatTourController extends Controller
{
    public function index(Request $request)
    {
        $query = DatTour::with([
            'tour',
            'nguoiDung',
            'lichKhoiHanh.huongDanVien'
        ]);

        // =====================
        // TÌM KIẾM
        // =====================
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

        // =====================
        // LỌC TRẠNG THÁI
        // =====================
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

        // =====================
        // THỐNG KÊ
        // =====================

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

            // Kiểm tra lịch đã tồn tại chưa
            $ngayKhoiHanh = \Carbon\Carbon::createFromFormat(
                'd/m/Y',
                $request->lich_khoi_hanh
            )->format('Y-m-d');
            $lichKhoiHanh = LichKhoiHanhTour::where(
                'tour_id',
                $tour->id
            )
                ->where(
                    'ngay_khoi_hanh',
                    $ngayKhoiHanh
                )
                ->first();

            // Nếu chưa có thì tạo lịch mới
            if (!$lichKhoiHanh) {
                $soNgayTour = $tour->lichTrinh->count();
                $lichKhoiHanh = LichKhoiHanhTour::create([
                    'tour_id' => $tour->id,
                    'ngay_khoi_hanh' => $ngayKhoiHanh,
                    'ngay_ket_thuc' => \Carbon\Carbon::parse($ngayKhoiHanh)
                        ->addDays($soNgayTour - 1),
                    'so_cho_con_lai' => 40,
                    'so_cho_da_dat' => 0,
                    'trang_thai' => 'available',
                ]);
            }
            // Kiểm tra số chỗ còn lại
            if ($lichKhoiHanh->so_cho_con_lai < $tongKhach) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Lịch khởi hành không đủ chỗ trống'
                    );
            }

            //validate ngày khởi hành
            // $request->validate([
            //     'ngay_khoi_hanh' => [
            //         'required',
            //         'date',
            //         'after_or_equal:today'
            //     ]
            // ]);

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

            // ===========================
            // TẠO THANH TOÁN CHO BOOKING
            // ===========================
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
            ->where('trang_thai', 'available')
            ->get();

        return response()->json($lichs);
    }

    // // Cập nhật phương tiện
    // public function updateXe(Request $request, $id)
    // {
    //     $request->validate([
    //         'phuong_tien_id' => 'required'
    //     ]);

    //     $booking = DatTour::findOrFail($id);

    //     if ($booking->lichKhoiHanh) {

    //         $booking->lichKhoiHanh->update([
    //             'phuong_tien_id' => $request->phuong_tien_id
    //         ]);
    //     }

    //     return back()->with(
    //         'success',
    //         'Đã cập nhật phương tiện'
    //     );
    // }
}
