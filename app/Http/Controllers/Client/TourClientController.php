<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\DanhSachTour;
use App\Models\DanhSachTourYeuThich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourClientController extends Controller
{
    public function index(Request $request)
    {
        $query = DanhSachTour::with([
            'danhMuc',
            'lichKhoiHanhTours',
        ])
            ->where('trang_thai', 'active');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

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
            $query->where('gia_tour', '>=', $request->gia_min);
        }

        if ($request->filled('gia_max')) {
            $query->where('gia_tour', '<=', $request->gia_max);
        }

        if ($request->filled('phuong_tien')) {
            $query->where('phuong_tien', 'like', '%' . $request->phuong_tien . '%');
        }

        if ($request->filled('ngay_khoi_hanh')) {
            $query->whereHas('lichKhoiHanhTours', function ($q) use ($request) {
                $q->whereDate('ngay_khoi_hanh', $request->ngay_khoi_hanh);
            });
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('gia_tour', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('gia_tour', 'desc');
        } else {
            $query->latest();
        }

        $tours = $query->paginate(12)->withQueryString();

        $danhMucs = DanhMuc::where('trang_thai', 'active')
            ->orderBy('ten_danh_muc')
            ->get();

        $favoriteTourIds = [];

        if (Auth::check()) {
            $favoriteTourIds = DanhSachTourYeuThich::where('nguoi_dung_id', Auth::id())
                ->pluck('tour_id')
                ->toArray();
        }

        return view('Client.danh_sach_tour.index', compact(
            'tours',
            'danhMucs',
            'favoriteTourIds'
        ));
    }

    public function show($id)
    {
        $tour = DanhSachTour::with([
            'danhMuc',
            'hinhAnhTours',
            'lichTrinhTours',
            'lichKhoiHanhTours',
        ])
            ->where('trang_thai', 'active')
            ->findOrFail($id);

        $lichGanNhat = $tour->lichKhoiHanhTours
            ->where('trang_thai', 'available')
            ->sortBy('ngay_khoi_hanh')
            ->first();

        $soSaoTrungBinh = 0;
        $soLuotDat = 0;

        if (method_exists($tour, 'danhGia')) {
            $soSaoTrungBinh = $tour->danhGia()->avg('so_sao') ?? 0;
        }

        if (method_exists($tour, 'datTours')) {
            $soLuotDat = $tour->datTours()->count();
        }

        $isFavorite = false;

        if (Auth::check()) {
            $isFavorite = DanhSachTourYeuThich::where('nguoi_dung_id', Auth::id())
                ->where('tour_id', $tour->id)
                ->exists();
        }

        return view('Client.danh_sach_tour.show', compact(
            'tour',
            'lichGanNhat',
            'soSaoTrungBinh',
            'soLuotDat',
            'isFavorite'
        ));
    }
}