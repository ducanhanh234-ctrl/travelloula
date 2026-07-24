<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\DanhSachTour;
use App\Models\DanhSachTourYeuThich;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TourClientController extends Controller
{
    public function index(Request $request)
    {
        $query = DanhSachTour::query()
            ->with([
                'danhMuc',

                /*
                 * Tải toàn bộ lịch để Blade có thể xác định chính xác:
                 * - Tour chưa có lịch.
                 * - Lịch đã qua ngày.
                 * - Lịch hết chỗ.
                 * - Lịch đã đóng.
                 * - Lịch đang diễn ra.
                 */
                'lichKhoiHanhTours' => function ($query) {
                    $query
                        ->whereIn('trang_thai', [
                            'available',
                            'running',
                            'full',
                            'closed',
                        ])
                        ->orderBy('ngay_khoi_hanh')
                        ->orderBy('id');
                },
            ])
            ->where('trang_thai', 'active');

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('ten_tour', 'like', "%{$keyword}%")
                    ->orWhere('diem_den', 'like', "%{$keyword}%")
                    ->orWhere('dia_diem_khoi_hanh', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('danh_muc_id')) {
            $query->where('danh_muc_id', $request->danh_muc_id);
        }

        if ($request->filled('gia_min')) {
            $query->where('gia_tour', '>=', (float) $request->gia_min);
        }

        if ($request->filled('gia_max')) {
            $query->where('gia_tour', '<=', (float) $request->gia_max);
        }

        if ($request->filled('phuong_tien')) {
            $phuongTien = trim((string) $request->phuong_tien);

            $query->where(
                'phuong_tien',
                'like',
                "%{$phuongTien}%"
            );
        }

        /*
         * Khi người dùng tìm theo ngày khởi hành, chỉ lấy lịch:
         * - Đúng ngày đã chọn.
         * - Đang mở bán.
         * - Còn chỗ.
         */
        if ($request->filled('ngay_khoi_hanh')) {
            $query->whereHas('lichKhoiHanhTours', function ($q) use ($request) {
                $q->whereDate(
                    'ngay_khoi_hanh',
                    $request->ngay_khoi_hanh
                )
                    ->where('trang_thai', 'available')
                    ->where('so_cho_con_lai', '>', 0);
            });
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('gia_tour');
        } elseif ($request->sort === 'price_desc') {
            $query->orderByDesc('gia_tour');
        } else {
            $query->latest('id');
        }

        $tours = $query
            ->paginate(12)
            ->withQueryString();

        $danhMucs = DanhMuc::query()
            ->where('trang_thai', 'active')
            ->orderBy('ten_danh_muc')
            ->get();

        $favoriteTourIds = [];

        if (Auth::check()) {
            $favoriteTourIds = DanhSachTourYeuThich::query()
                ->where('nguoi_dung_id', Auth::id())
                ->pluck('tour_id')
                ->map(fn ($tourId) => (int) $tourId)
                ->all();
        }

        return view('Client.danh_sach_tour.index', compact(
            'tours',
            'danhMucs',
            'favoriteTourIds'
        ));
    }

    public function show($id)
    {
        $tour = DanhSachTour::query()
            ->with([
                'danhMuc',
                'hinhAnhTours',

                'lichTrinhTours' => function ($query) {
                    $query
                        ->orderBy('ngay_thu')
                        ->orderBy('id');
                },

                'lichKhoiHanhTours' => function ($query) {
                    $query
                        ->whereIn('trang_thai', [
                            'available',
                            'running',
                            'full',
                            'closed',
                        ])
                        ->orderBy('ngay_khoi_hanh')
                        ->orderBy('id');
                },

                'danhGia' => function ($query) {
                    $query
                        ->where('hien_thi', 1)
                        ->with([
                            'user',
                            'khachHangDatTour',
                        ])
                        ->orderByDesc('thoi_gian_danh_gia')
                        ->orderByDesc('id');
                },
            ])
            ->where('trang_thai', 'active')
            ->findOrFail($id);

        $homNay = now()->startOfDay();

        $tatCaLichKhoiHanhs = collect(
            $tour->lichKhoiHanhTours ?? []
        )
            ->sortBy('ngay_khoi_hanh')
            ->values();

        $lichKhoiHanhsSapToi = $tatCaLichKhoiHanhs
            ->filter(function ($lich) use ($homNay) {
                if (empty($lich->ngay_khoi_hanh)) {
                    return false;
                }

                return Carbon::parse($lich->ngay_khoi_hanh)
                    ->startOfDay()
                    ->gte($homNay);
            })
            ->values();

        /*
         * Chỉ lịch thỏa mãn đủ ba điều kiện mới được đặt:
         * 1. Chưa qua ngày khởi hành.
         * 2. Trạng thái available.
         * 3. Còn ít nhất một chỗ.
         */
        $lichCoTheDat = $lichKhoiHanhsSapToi
            ->filter(function ($lich) {
                return $lich->trang_thai === 'available'
                    && (int) $lich->so_cho_con_lai > 0;
            })
            ->sortBy('ngay_khoi_hanh')
            ->values();

        $lichGanNhat = $lichCoTheDat->first();
        $coTheDatTour = $lichGanNhat !== null;

        $lyDoKhongDat = $this->getBookingUnavailableReason(
            $tatCaLichKhoiHanhs,
            $lichKhoiHanhsSapToi,
            $coTheDatTour
        );

        $soSaoTrungBinh = round(
            (float) ($tour->danhGia->avg('so_sao') ?? 0),
            1
        );

        $tongDanhGia = $tour->danhGia->count();

        $soLuotDat = method_exists($tour, 'datTours')
            ? $tour->datTours()->count()
            : 0;

        $isFavorite = false;

        if (Auth::check()) {
            $isFavorite = DanhSachTourYeuThich::query()
                ->where('nguoi_dung_id', Auth::id())
                ->where('tour_id', $tour->id)
                ->exists();
        }

        return view('Client.danh_sach_tour.show', compact(
            'tour',
            'lichGanNhat',
            'lichCoTheDat',
            'coTheDatTour',
            'lyDoKhongDat',
            'soSaoTrungBinh',
            'tongDanhGia',
            'soLuotDat',
            'isFavorite'
        ));
    }

    /**
     * Trả về lý do cụ thể khi tour chưa thể đặt.
     */
    private function getBookingUnavailableReason(
        Collection $tatCaLichKhoiHanhs,
        Collection $lichKhoiHanhsSapToi,
        bool $coTheDatTour
    ): ?string {
        if ($coTheDatTour) {
            return null;
        }

        if ($tatCaLichKhoiHanhs->isEmpty()) {
            return 'Tour này chưa được tạo lịch khởi hành. Vui lòng quay lại sau hoặc liên hệ tư vấn để được thông báo khi có lịch mới.';
        }

        if ($lichKhoiHanhsSapToi->isEmpty()) {
            return 'Tour hiện không còn lịch khởi hành sắp tới. Các lịch đã tạo đều đã qua ngày khởi hành.';
        }

        if ($lichKhoiHanhsSapToi->every(
            fn ($lich) => $lich->trang_thai === 'closed'
        )) {
            return 'Tất cả lịch khởi hành sắp tới của tour đã đóng đăng ký.';
        }

        if ($lichKhoiHanhsSapToi->every(function ($lich) {
            return $lich->trang_thai === 'full'
                || (int) $lich->so_cho_con_lai <= 0;
        })) {
            return 'Tất cả lịch khởi hành sắp tới của tour đã hết chỗ.';
        }

        if ($lichKhoiHanhsSapToi->every(
            fn ($lich) => $lich->trang_thai === 'running'
        )) {
            return 'Các lịch khởi hành của tour hiện đang diễn ra nên hệ thống không thể nhận thêm khách.';
        }

        return 'Tour có lịch khởi hành nhưng hiện chưa có lịch nào đang mở bán và còn chỗ.';
    }
}