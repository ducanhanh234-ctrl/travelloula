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
            $query->where('gia_tour', '>=', $request->gia_min);
        }

        if ($request->filled('gia_max')) {
            $query->where('gia_tour', '<=', $request->gia_max);
        }

        if ($request->filled('phuong_tien')) {
            $query->where(
                'phuong_tien',
                'like',
                '%' . trim((string) $request->phuong_tien) . '%'
            );
        }

        if ($request->filled('ngay_khoi_hanh')) {
            $query->whereHas('lichKhoiHanhTours', function ($q) use ($request) {
                $q->whereDate('ngay_khoi_hanh', $request->ngay_khoi_hanh);
            });
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('gia_tour');
        } elseif ($request->sort === 'price_desc') {
            $query->orderByDesc('gia_tour');
        } else {
            $query->latest('id');
        }

        $tours = $query->paginate(12)->withQueryString();

        $danhMucs = DanhMuc::query()
            ->where('trang_thai', 'active')
            ->orderBy('ten_danh_muc')
            ->get();

        $favoriteTourIds = [];

        if (Auth::check()) {
            $favoriteTourIds = DanhSachTourYeuThich::query()
                ->where('nguoi_dung_id', Auth::id())
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

            'lichKhoiHanhTours' => function ($query) {
                $query->orderBy('ngay_khoi_hanh');
            },

            'danhGia' => function ($query) {
                $query
                    ->where('hien_thi', 1)
                    ->with([
                        'user',
                        'khachHangDatTour',
                    ])
                    ->orderByDesc('thoi_gian_danh_gia');
            },
        ])
            ->where('trang_thai', 'active')
            ->findOrFail($id);

        $lichGanNhat = $tour->lichKhoiHanhTours
            ->filter(function ($lich) {
                return $lich->trang_thai === 'available'
                    && (int) $lich->so_cho_con_lai > 0;
            })
            ->sortBy('ngay_khoi_hanh')
            ->first();

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
            'soSaoTrungBinh',
            'tongDanhGia',
            'soLuotDat',
            'isFavorite'
        ));
    }
}
