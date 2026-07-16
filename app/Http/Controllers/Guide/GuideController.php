<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\HuongDanVien;
use App\Models\KhachHangDatTour;
use App\Models\PhanCong;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        $tours = PhanCong::with([
            'lichKhoiHanh.tour',
            'phuongTien',
            'hdv'
        ])
            ->whereHas('hdv', function ($query) {
                $query->where('email', auth()->user()->email);
            })
            ->latest()
            ->get();

        return view('Guide.tour_dc_phan_cong', compact('tours'));
    }
    public function show($id)
    {
        $tour = PhanCong::with([
            'lichKhoiHanh.tour',
            'phuongTien',
            'hdv'
        ])->findOrFail($id);

        return view('Guide.show_tour_phan_cong', compact('tour'));
    }
    public function lichtrinh($phanCongId)
    {
        // Lấy hướng dẫn viên đang đăng nhập
        $hdv = HuongDanVien::where('user_id', auth()->id())->firstOrFail();

        // Kiểm tra phân công có thuộc HDV này không
        $phanCong = PhanCong::with([
            'hdv',
            'phuongTien',
            'lichKhoiHanh.tour.lichTrinhs.chiTiets'
        ])
            ->where('id', $phanCongId)
            ->where('hdv_id', $hdv->id)
            ->firstOrFail();

        // Lấy tour
        $tour = $phanCong->lichKhoiHanh->tour;

        // Lấy lịch trình theo ngày
        $lichTrinhs = $tour->lichTrinhs()
            ->with('chiTiets')
            ->orderBy('ngay_thu')
            ->get();

        return view('Guide.lich_trinh', compact(
            'phanCong',
            'tour',
            'lichTrinhs'
        ));
    }
    public function khachhangdattour($phanCongId)
    {
        // Lấy hướng dẫn viên đang đăng nhập
        $hdv = HuongDanVien::where('user_id', auth()->id())->firstOrFail();

        // Kiểm tra phân công có thuộc HDV này không
        $phanCong = PhanCong::with([
            'hdv',
            'phuongTien',
            'lichKhoiHanh'
        ])
            ->where('id', $phanCongId)
            ->where('hdv_id', $hdv->id)
            ->firstOrFail();

        // Lấy danh sách khách hàng đã đặt tour
        $khachHangs = KhachHangDatTour::whereHas('datTour', function ($query) use ($phanCong) {
            $query->where('lich_khoi_hanh_id', $phanCong->lichKhoiHanh->id);
        })->get();

        return view('Guide.danh_sach_khach', compact(
            'phanCong',
            'khachHangs'
        ));
    }
}
