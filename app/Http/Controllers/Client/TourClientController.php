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
                 * Tải toàn bộ lịch để xác định lịch gần nhất có thể đặt
                 * và ngày dùng để đối chiếu bảng giá tour.
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

                /*
                 * Tải bảng giá đang hoạt động.
                 * Bảng giá được kiểm tra theo ngày khởi hành của từng tour.
                 */
                'bangGiaTours' => function ($query) {
                    $query
                        ->where('trang_thai', 'active')
                        ->orderByDesc('ngay_bat_dau')
                        ->orderByDesc('id');
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

        /*
         * Bộ lọc giá hiện vẫn lọc theo giá niêm yết trong danh_sach_tours.
         * Giá cao điểm phụ thuộc ngày khởi hành nên sẽ được tính sau khi
         * tải lịch và bảng giá của tour.
         */
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
         * Khi tìm theo ngày khởi hành, chỉ lấy lịch:
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

        $ngayTimKiem = null;

        if ($request->filled('ngay_khoi_hanh')) {
            try {
                $ngayTimKiem = Carbon::parse(
                    $request->ngay_khoi_hanh
                )->startOfDay();
            } catch (\Throwable $exception) {
                $ngayTimKiem = null;
            }
        }

        /*
         * Gắn dữ liệu giá hiển thị cho từng tour trên trang index.
         *
         * Các thuộc tính Blade có thể dùng:
         * - $tour->gia_niem_yet
         * - $tour->gia_hien_thi
         * - $tour->gia_nguoi_lon_niem_yet
         * - $tour->gia_nguoi_lon_hien_thi
         * - $tour->gia_tre_em_niem_yet
         * - $tour->gia_tre_em_hien_thi
         * - $tour->co_gia_cao_diem
         * - $tour->phan_tram_tang_hien_thi
         * - $tour->lichGiaApDung
         * - $tour->bang_gia_ap_dung
         */
        $tours->getCollection()->transform(function ($tour) use ($ngayTimKiem) {
            $lichGiaApDung = $this->getDepartureForIndexPrice(
                $tour,
                $ngayTimKiem
            );

            $this->attachDisplayPrice(
                $tour,
                $lichGiaApDung?->ngay_khoi_hanh
            );

            $tour->setRelation('lichGiaApDung', $lichGiaApDung);

            return $tour;
        });

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

                'bangGiaTours' => function ($query) {
                    $query
                        ->where('trang_thai', 'active')
                        ->orderByDesc('ngay_bat_dau')
                        ->orderByDesc('id');
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

        /*
         * Gắn giá riêng cho từng lịch khởi hành.
         * Blade chi tiết có thể đọc trực tiếp từ từng $lich.
         */
        $tatCaLichKhoiHanhs->each(function ($lich) use ($tour) {
            $priceData = $this->resolvePriceData(
                $tour,
                $lich->ngay_khoi_hanh
            );

            foreach ($priceData as $key => $value) {
                $lich->setAttribute($key, $value);
            }
        });

        $lichGanNhat = $lichCoTheDat->first();
        $coTheDatTour = $lichGanNhat !== null;

        /*
         * Giá chính ở đầu trang chi tiết lấy theo lịch gần nhất có thể đặt.
         * Nếu chưa có lịch phù hợp, hệ thống dùng giá niêm yết của tour.
         */
        $this->attachDisplayPrice(
            $tour,
            $lichGanNhat?->ngay_khoi_hanh
        );

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
     * Chọn ngày dùng để hiển thị giá trên trang danh sách.
     *
     * - Có lọc ngày: dùng đúng ngày người dùng đã chọn.
     * - Không lọc ngày: dùng lịch gần nhất đang mở bán và còn chỗ.
     * - Không có lịch phù hợp: trả về null, dùng giá niêm yết.
     */
    private function getDepartureForIndexPrice(
        DanhSachTour $tour,
        ?Carbon $ngayTimKiem = null
    ) {
        $homNay = now()->startOfDay();

        $lichKhoiHanhs = collect($tour->lichKhoiHanhTours ?? [])
            ->filter(fn ($lich) => !empty($lich->ngay_khoi_hanh));

        if ($ngayTimKiem) {
            return $lichKhoiHanhs
                ->first(function ($lich) use ($ngayTimKiem) {
                    return Carbon::parse($lich->ngay_khoi_hanh)
                            ->isSameDay($ngayTimKiem)
                        && $lich->trang_thai === 'available'
                        && (int) $lich->so_cho_con_lai > 0;
                });
        }

        return $lichKhoiHanhs
            ->filter(function ($lich) use ($homNay) {
                return Carbon::parse($lich->ngay_khoi_hanh)
                        ->startOfDay()
                        ->gte($homNay)
                    && $lich->trang_thai === 'available'
                    && (int) $lich->so_cho_con_lai > 0;
            })
            ->sortBy('ngay_khoi_hanh')
            ->first();
    }

    /**
     * Gắn các trường giá động vào model tour để Blade sử dụng.
     */
    private function attachDisplayPrice(
        DanhSachTour $tour,
        $ngayKhoiHanh = null
    ): void {
        $priceData = $this->resolvePriceData($tour, $ngayKhoiHanh);

        foreach ($priceData as $key => $value) {
            $tour->setAttribute($key, $value);
        }
    }

    /**
     * Xác định bảng giá áp dụng theo đúng ngày khởi hành.
     *
     * Tour ngoài cao điểm:
     * - Dùng giá trong danh_sach_tours.
     * - Không gạch giá.
     *
     * Tour trong cao điểm:
     * - Giá niêm yết lấy từ danh_sach_tours.
     * - Giá hiện tại lấy từ bang_gia_tours.
     * - Blade có thể gạch giá niêm yết và làm nổi bật giá hiện tại.
     */
    private function resolvePriceData(
        DanhSachTour $tour,
        $ngayKhoiHanh = null
    ): array {
        $giaNguoiLonNiemYet = $this->normalizeMoney(
            ((float) ($tour->gia_nguoi_lon ?? 0) > 0)
                ? $tour->gia_nguoi_lon
                : $tour->gia_tour
        );

        $giaTreEmNiemYet = $this->normalizeMoney(
            $tour->gia_tre_em ?? 0
        );

        $bangGiaApDung = null;
        $ngayApDung = null;

        if (!empty($ngayKhoiHanh)) {
            try {
                $ngayApDung = Carbon::parse($ngayKhoiHanh)->startOfDay();
            } catch (\Throwable $exception) {
                $ngayApDung = null;
            }
        }

        if ($ngayApDung) {
            $bangGiaApDung = collect($tour->bangGiaTours ?? [])
                ->filter(function ($bangGia) use ($ngayApDung) {
                    if (
                        $bangGia->trang_thai !== 'active'
                        || empty($bangGia->ngay_bat_dau)
                        || empty($bangGia->ngay_ket_thuc)
                    ) {
                        return false;
                    }

                    $ngayBatDau = Carbon::parse(
                        $bangGia->ngay_bat_dau
                    )->startOfDay();

                    $ngayKetThuc = Carbon::parse(
                        $bangGia->ngay_ket_thuc
                    )->endOfDay();

                    return $ngayApDung->gte($ngayBatDau)
                        && $ngayApDung->lte($ngayKetThuc);
                })
                ->sortByDesc(function ($bangGia) {
                    return sprintf(
                        '%s-%020d',
                        (string) $bangGia->ngay_bat_dau,
                        (int) $bangGia->id
                    );
                })
                ->first();
        }

        $giaNguoiLonBangGia = $bangGiaApDung
            ? $this->normalizeMoney($bangGiaApDung->gia_nguoi_lon ?? 0)
            : 0;

        $giaTreEmBangGia = $bangGiaApDung
            ? $this->normalizeMoney($bangGiaApDung->gia_tre_em ?? 0)
            : 0;

        $giaNguoiLonHienThi = $giaNguoiLonBangGia > 0
            ? $giaNguoiLonBangGia
            : $giaNguoiLonNiemYet;

        $giaTreEmHienThi = $giaTreEmBangGia > 0
            ? $giaTreEmBangGia
            : $giaTreEmNiemYet;

        $phanTramTang = $bangGiaApDung
            ? (int) ($bangGiaApDung->phan_tram_tang ?? 0)
            : 0;

        /*
         * Chỉ gạch giá khi bảng giá thực sự làm thay đổi giá.
         * Các dòng bang_gia_tours có 0% và giá bằng giá niêm yết
         * sẽ được hiển thị như giá thường.
         */
        $coGiaThayDoi = $bangGiaApDung !== null
            && (
                $phanTramTang > 0
                || $giaNguoiLonHienThi !== $giaNguoiLonNiemYet
                || $giaTreEmHienThi !== $giaTreEmNiemYet
            );

        return [
            'gia_niem_yet' => $giaNguoiLonNiemYet,
            'gia_hien_thi' => $giaNguoiLonHienThi,

            'gia_nguoi_lon_niem_yet' => $giaNguoiLonNiemYet,
            'gia_nguoi_lon_hien_thi' => $giaNguoiLonHienThi,

            'gia_tre_em_niem_yet' => $giaTreEmNiemYet,
            'gia_tre_em_hien_thi' => $giaTreEmHienThi,

            'co_gia_cao_diem' => $coGiaThayDoi,
            'phan_tram_tang_hien_thi' => $phanTramTang,
            'bang_gia_ap_dung' => $bangGiaApDung,
            'ngay_gia_ap_dung' => $ngayApDung?->toDateString(),
        ];
    }

    /**
     * Chuyển giá decimal về số nguyên để hiển thị tiền Việt Nam.
     */
    private function normalizeMoney($value): int
    {
        return max(0, (int) round((float) $value));
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