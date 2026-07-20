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
        | Đánh giá đã được phép hiển thị
        |--------------------------------------------------------------------------
        | Database dùng danh_gia.hien_thi = 1.
        */
        $avgRating = 0.0;

        if (
            Schema::hasTable('danh_gia')
            && Schema::hasColumn('danh_gia', 'so_sao')
        ) {
            $ratingQuery = DB::table('danh_gia');

            if (Schema::hasColumn('danh_gia', 'hien_thi')) {
                $ratingQuery->where('hien_thi', 1);
            }

            $avgRating = round(
                (float) ($ratingQuery->avg('so_sao') ?? 0),
                1
            );
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
            'khuyenMais',
            'favoriteTourIds'
        ));
    }
}