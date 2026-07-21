<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\DanhSachTour;
use App\Models\DanhSachTourYeuThich;
use App\Models\KhachHangDatTour;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeClientController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Tour hiển thị trên trang chủ
        |--------------------------------------------------------------------------
        | Theo database:
        | - danh_sach_tours.trang_thai = active
        | - Tour phải có ít nhất một bản ghi trong lich_trinh_tours
        */
        $tourTrangChuQuery = DanhSachTour::query()
            ->where('trang_thai', 'active')
            ->whereHas('lichTrinhTours');

        /*
        |--------------------------------------------------------------------------
        | Tour và lịch khởi hành
        |--------------------------------------------------------------------------
        | Database dùng đúng các trạng thái:
        | available, running, full, closed.
        */
        $tours = (clone $tourTrangChuQuery)
            ->with([
                'danhMuc',
                'lichTrinhTours',
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
            ->latest('id')
            ->take(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Điểm đến nổi bật
        |--------------------------------------------------------------------------
        */
        $diemDens = DanhSachTour::query()
            ->where('trang_thai', 'active')
            ->whereHas('lichTrinhTours')
            ->whereNotNull('diem_den')
            ->where('diem_den', '<>', '')
            ->selectRaw(
                'MIN(id) AS id, diem_den, MIN(anh_dai_dien) AS anh_dai_dien'
            )
            ->groupBy('diem_den')
            ->orderBy('diem_den')
            ->take(6)
            ->get();

        $danhMucs = DanhMuc::query()
            ->where('trang_thai', 'active')
            ->orderBy('ten_danh_muc')
            ->get();

        $totalTours = (clone $tourTrangChuQuery)->count();

        $totalDiemDen = DanhSachTour::query()
            ->where('trang_thai', 'active')
            ->whereHas('lichTrinhTours')
            ->whereNotNull('diem_den')
            ->where('diem_den', '<>', '')
            ->distinct()
            ->count('diem_den');

        $totalKhachHang = Schema::hasTable('khach_hang_dat_tours')
            ? KhachHangDatTour::count()
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Đánh giá thật đã được quản trị viên duyệt
        |--------------------------------------------------------------------------
        | Chỉ lấy danh_gia.hien_thi = 1.
        | Bảng danh_gia liên kết khách hàng qua khach_hang_dat_tour_id,
        | không sử dụng user_id.
        */
        $avgRating = 0.0;
        $totalReviews = 0;
        $homeReviews = collect();
        $reviewStatsByTour = collect();

        if (
            Schema::hasTable('danh_gia')
            && Schema::hasColumn('danh_gia', 'so_sao')
        ) {
            $approvedReviewsQuery = DB::table('danh_gia');

            if (Schema::hasColumn('danh_gia', 'hien_thi')) {
                $approvedReviewsQuery->where('hien_thi', 1);
            }

            $avgRating = round(
                (float) ((clone $approvedReviewsQuery)->avg('so_sao') ?? 0),
                1
            );

            $totalReviews = (clone $approvedReviewsQuery)->count();

            if (Schema::hasColumn('danh_gia', 'tour_id')) {
                $reviewStatsQuery = DB::table('danh_gia')
                    ->selectRaw(
                        'tour_id, COUNT(*) AS tong_danh_gia, AVG(so_sao) AS diem_trung_binh'
                    )
                    ->whereNotNull('tour_id');

                if (Schema::hasColumn('danh_gia', 'hien_thi')) {
                    $reviewStatsQuery->where('hien_thi', 1);
                }

                $reviewStatsByTour = $reviewStatsQuery
                    ->groupBy('tour_id')
                    ->get()
                    ->keyBy('tour_id');
            }

            if (
                Schema::hasTable('khach_hang_dat_tours')
                && Schema::hasTable('danh_sach_tours')
                && Schema::hasColumn('danh_gia', 'khach_hang_dat_tour_id')
                && Schema::hasColumn('danh_gia', 'tour_id')
            ) {
                $homeReviewsQuery = DB::table('danh_gia as dg')
                    ->leftJoin(
                        'khach_hang_dat_tours as kh',
                        'kh.id',
                        '=',
                        'dg.khach_hang_dat_tour_id'
                    )
                    ->leftJoin(
                        'danh_sach_tours as tour',
                        'tour.id',
                        '=',
                        'dg.tour_id'
                    )
                    ->whereNotNull('dg.noi_dung_danh_gia');

                if (Schema::hasColumn('danh_gia', 'hien_thi')) {
                    $homeReviewsQuery->where('dg.hien_thi', 1);
                }

                $homeReviews = $homeReviewsQuery
                    ->select([
                        'dg.id',
                        'dg.tour_id',
                        'dg.so_sao',
                        'dg.tieu_de',
                        'dg.noi_dung_danh_gia',
                        'dg.thoi_gian_danh_gia',
                        'kh.ho_ten',
                        'tour.ten_tour',
                    ])
                    ->orderByDesc('dg.thoi_gian_danh_gia')
                    ->orderByDesc('dg.id')
                    ->take(6)
                    ->get();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Khuyến mãi còn hiệu lực
        |--------------------------------------------------------------------------
        */
        $khuyenMais = collect();

        if (Schema::hasTable('khuyen_mais')) {
            $khuyenMais = DB::table('khuyen_mais')
                ->where('trang_thai', 'active')
                ->whereDate('ngay_bat_dau', '<=', now()->toDateString())
                ->whereDate('ngay_ket_thuc', '>=', now()->toDateString())
                ->orderBy('ngay_ket_thuc')
                ->take(2)
                ->get();
        }

        $favoriteTourIds = [];

        if (Auth::check()) {
            $favoriteTourIds = DanhSachTourYeuThich::query()
                ->where('nguoi_dung_id', Auth::id())
                ->pluck('tour_id')
                ->map(fn($tourId) => (int) $tourId)
                ->all();
        }

        return view('Client.trang_chu.index', compact(
            'tours',
            'diemDens',
            'danhMucs',
            'totalTours',
            'totalDiemDen',
            'totalKhachHang',
            'avgRating',
            'totalReviews',
            'homeReviews',
            'reviewStatsByTour',
            'khuyenMais',
            'favoriteTourIds'
        ));
    }

    public function landingPage()
    {
        $featuredTours = DanhSachTour::with(['danhMuc', 'lichKhoiHanhTours'])
            ->where('trang_thai', 'active')
            ->latest()
            ->take(8)
            ->get();

        $tourCards = $featuredTours->map(function ($tour) {
            $firstDeparture = $tour->lichKhoiHanhTours->sortBy('ngay_khoi_hanh')->first();
            $price = (float) $tour->gia_tour;
            $originalPrice = round($price * 1.15, 0);

            return [
                'id' => $tour->id,
                'title' => $tour->ten_tour,
                'location' => $tour->diem_den ?: $tour->dia_diem_khoi_hanh,
                'price' => number_format($price, 0, ',', '.') . 'đ',
                'original_price' => number_format($originalPrice, 0, ',', '.') . 'đ',
                'discount' => 'Giảm 15%',
                'duration' => $tour->thoi_luong ?: 'Thời gian linh hoạt',
                'departure' => $firstDeparture && $firstDeparture->ngay_khoi_hanh
                    ? $firstDeparture->ngay_khoi_hanh->format('d/m/Y')
                    : 'Sắp mở',
                'image' => $tour->anh_dai_dien ?: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80',
                'tag' => $tour->danhMuc->ten_danh_muc ?? 'Tour nổi bật',
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Đánh giá thật cho landing page
        |--------------------------------------------------------------------------
        */
        $landingReviews = collect();

        if (
            Schema::hasTable('danh_gia')
            && Schema::hasTable('khach_hang_dat_tours')
            && Schema::hasTable('danh_sach_tours')
            && Schema::hasColumn('danh_gia', 'khach_hang_dat_tour_id')
            && Schema::hasColumn('danh_gia', 'tour_id')
        ) {
            $landingReviewsQuery = DB::table('danh_gia as dg')
                ->leftJoin(
                    'khach_hang_dat_tours as kh',
                    'kh.id',
                    '=',
                    'dg.khach_hang_dat_tour_id'
                )
                ->leftJoin(
                    'danh_sach_tours as tour',
                    'tour.id',
                    '=',
                    'dg.tour_id'
                )
                ->whereNotNull('dg.noi_dung_danh_gia');

            if (Schema::hasColumn('danh_gia', 'hien_thi')) {
                $landingReviewsQuery->where('dg.hien_thi', 1);
            }

            $landingReviews = $landingReviewsQuery
                ->select([
                    'dg.so_sao',
                    'dg.noi_dung_danh_gia',
                    'dg.thoi_gian_danh_gia',
                    'kh.ho_ten',
                    'tour.ten_tour',
                ])
                ->orderByDesc('dg.thoi_gian_danh_gia')
                ->orderByDesc('dg.id')
                ->take(6)
                ->get();
        }

        $reviewGroups = $landingReviews->isEmpty()
            ? []
            : $landingReviews
                ->map(function ($review) {
                    return [
                        'name' => $review->ho_ten ?: 'Khách hàng',
                        'role' => $review->ten_tour
                            ? 'Đã trải nghiệm ' . $review->ten_tour
                            : 'Khách hàng đã đặt tour',
                        'quote' => $review->noi_dung_danh_gia,
                        'stars' => (int) $review->so_sao,
                    ];
                })
                ->chunk(3);

        $totalTours = DanhSachTour::where('trang_thai', 'active')->count();
        $totalKhachHang = Schema::hasTable('khach_hang_dat_tours') ? KhachHangDatTour::count() : 0;

        $avgRating = 0.0;

        if (
            Schema::hasTable('danh_gia')
            && Schema::hasColumn('danh_gia', 'so_sao')
        ) {
            $landingRatingQuery = DB::table('danh_gia');

            if (Schema::hasColumn('danh_gia', 'hien_thi')) {
                $landingRatingQuery->where('hien_thi', 1);
            }

            $avgRating = round(
                (float) ($landingRatingQuery->avg('so_sao') ?? 0),
                1
            );
        }

        $highlights = [
            ['icon' => 'fa-compass', 'title' => 'Hành trình riêng biệt', 'text' => 'Mỗi chuyến đi được thiết kế phù hợp với phong cách và nhu cầu cá nhân.'],
            ['icon' => 'fa-shield-halved', 'title' => 'An tâm tuyệt đối', 'text' => 'Quy trình rõ ràng, bảo hiểm và hỗ trợ 24/7 luôn sẵn sàng.'],
            ['icon' => 'fa-star', 'title' => 'Dịch vụ đồng bộ', 'text' => 'Khách sạn, xe đưa đón và hướng dẫn viên được chọn kỹ lưỡng.'],
        ];

        $reasons = [
            ['icon' => 'fa-wallet', 'title' => 'Giá minh bạch', 'text' => 'Thông tin chi phí rõ ràng trước khi thanh toán.'],
            ['icon' => 'fa-clock', 'title' => 'Linh hoạt', 'text' => 'Có thể điều chỉnh lịch trình theo nhu cầu của bạn.'],
            ['icon' => 'fa-headset', 'title' => 'Hỗ trợ tận tâm', 'text' => 'Đội ngũ chuyên gia luôn đồng hành cùng bạn.'],
        ];

        $steps = [
            ['title' => 'Chọn chuyến đi', 'text' => 'Duyệt danh sách tour phù hợp với thời gian và ngân sách.'],
            ['title' => 'Nhận tư vấn', 'text' => 'Chuyên gia sẽ đề xuất hành trình tối ưu trước khi đặt.'],
            ['title' => 'Xác nhận', 'text' => 'Đặt cọc nhanh gọn và theo dõi trạng thái đơn hàng.'],
            ['title' => 'Khởi hành', 'text' => 'Chúng tôi lo toàn bộ chi tiết để bạn thư giãn.'],
        ];

        $stats = [
            ['number' => $totalTours . '+', 'label' => 'tour mỗi năm'],
            ['number' => $avgRating . '/5', 'label' => 'đánh giá trung bình'],
            ['number' => $totalKhachHang . '+', 'label' => 'khách hàng'],
            ['number' => '24/7', 'label' => 'hỗ trợ khách hàng'],
        ];

        $faqs = [
            ['question' => 'Travelloula có hỗ trợ đặt tour theo nhu cầu riêng không?', 'answer' => 'Có. Chúng tôi có thể thiết kế lịch trình riêng cho các nhóm, gia đình, cặp đôi hoặc doanh nghiệp.'],
            ['question' => 'Tour có thể thay đổi trước khi khởi hành không?', 'answer' => 'Hoàn toàn có thể. Đội ngũ tư vấn sẽ hỗ trợ điều chỉnh cho phù hợp nhất với kế hoạch của bạn.'],
            ['question' => 'Thông tin chi phí có minh bạch không?', 'answer' => 'Có. Mọi khoản phí đều được báo trước rõ ràng, không phát sinh bất ngờ trong quá trình vận hành.'],
        ];

        return view('Client.landing.index', compact(
            'tourCards',
            'reviewGroups',
            'stats',
            'faqs',
            'highlights',
            'reasons',
            'steps'
        ));
    }
}