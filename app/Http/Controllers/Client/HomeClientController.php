<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\DanhSachTour;
use App\Models\KhachHangDatTour;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeClientController extends Controller
{
    public function index()
    {
        $tours = DanhSachTour::with(['danhMuc', 'lichKhoiHanhTours'])
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

        return view('Client.trang_chu.index', compact(
            'tours',
            'diemDens',
            'danhMucs',
            'totalTours',
            'totalDiemDen',
            'totalKhachHang',
            'avgRating',
            'khuyenMais'
        ));
    }
}