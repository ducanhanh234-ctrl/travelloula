<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
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
        $tours = DanhSachTour::with([
            'danhMuc',
            'lichKhoiHanhTours',
        ])
            ->where('trang_thai', 'active')
            ->latest()
            ->take(4)
            ->get();

        $diemDens = DanhSachTour::where('trang_thai', 'active')
            ->whereNotNull('diem_den')
            ->selectRaw('MIN(id) as id, diem_den, MIN(anh_dai_dien) as anh_dai_dien')
            ->groupBy('diem_den')
            ->take(6)
            ->get();

        $danhMucs = DanhMuc::where('trang_thai', 'active')
            ->orderBy('ten_danh_muc')
            ->take(6)
            ->get();

        $totalTours = DanhSachTour::where('trang_thai', 'active')->count();

        $totalDiemDen = DanhSachTour::where('trang_thai', 'active')
            ->whereNotNull('diem_den')
            ->distinct('diem_den')
            ->count('diem_den');

        $totalKhachHang = 0;

        if (Schema::hasTable('khach_hang_dat_tours')) {
            $totalKhachHang = KhachHangDatTour::count();
        }

        $avgRating = 4.9;

        if (Schema::hasTable('danh_gia') && Schema::hasColumn('danh_gia', 'so_sao')) {
            $rating = DB::table('danh_gia')->avg('so_sao');

            if ($rating) {
                $avgRating = round($rating, 1);
            }
        }

        $khuyenMais = collect();

        if (Schema::hasTable('khuyen_mais')) {
            $query = DB::table('khuyen_mais');

            if (Schema::hasColumn('khuyen_mais', 'trang_thai')) {
                $query->where(function ($q) {
                    $q->whereNull('trang_thai')
                        ->orWhere('trang_thai', 'active')
                        ->orWhere('trang_thai', 'hoat_dong')
                        ->orWhere('trang_thai', 1);
                });
            }

            if (Schema::hasColumn('khuyen_mais', 'created_at')) {
                $query->orderByDesc('created_at');
            }

            $khuyenMais = $query->take(2)->get();
        }

        $favoriteTourIds = [];

        if (Auth::check()) {
            $favoriteTourIds = DanhSachTourYeuThich::where('nguoi_dung_id', Auth::id())
                ->pluck('tour_id')
                ->toArray();
        }

        return view('Client.trang_chu.index', compact(
            'tours',
            'diemDens',
            'danhMucs',
            'totalTours',
            'totalDiemDen',
            'totalKhachHang',
            'avgRating',
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

        $reviews = DanhGia::query()
            ->where('hien_thi', true)
            ->whereNotNull('noi_dung_danh_gia')
            ->latest('thoi_gian_danh_gia')
            ->take(6)
            ->get();

        $reviewGroups = $reviews->isEmpty()
            ? []
            : $reviews->map(function ($review, $index) {
                return [
                    'name' => 'Khách hàng ' . ($index + 1),
                    'role' => 'Khách hàng đã đặt tour',
                    'quote' => $review->noi_dung_danh_gia,
                    'stars' => (int) $review->so_sao,
                ];
            })->chunk(3);

        $totalTours = DanhSachTour::where('trang_thai', 'active')->count();
        $totalKhachHang = Schema::hasTable('khach_hang_dat_tours') ? KhachHangDatTour::count() : 0;

        $avgRating = 4.9;
        if (Schema::hasTable('danh_gia') && Schema::hasColumn('danh_gia', 'so_sao')) {
            $rating = DB::table('danh_gia')->avg('so_sao');
            if ($rating) {
                $avgRating = round($rating, 1);
            }
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
