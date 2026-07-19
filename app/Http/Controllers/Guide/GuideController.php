<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\HuongDanVien;
use App\Models\KhachHangDatTour;
use App\Models\PhanCong;
use App\Models\PhuongTien;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        $hdvId = HuongDanVien::where('email', auth()->user()->email)
            ->value('id');

        $tours = PhanCong::with([
            'lichKhoiHanh.tour',
            'hdv',
        ])
            ->whereJsonContains('hdv_ids', (string) $hdvId)
            ->latest()
            ->get();

        // Lấy danh sách phương tiện của từng phân công
        foreach ($tours as $tour) {
            $ids = $tour->phuong_tien_ids ?? [];

            if (!is_array($ids)) {
                $ids = json_decode($ids, true) ?? [];
            }

            $tour->dsPhuongTien = PhuongTien::whereIn('id', $ids)->get();
        }

        return view('Guide.tour_dc_phan_cong', compact('tours'));
    }
    public function show($id)
    {
        $hdvId = HuongDanVien::where('email', auth()->user()->email)
            ->value('id');

        $tour = PhanCong::with([
            'lichKhoiHanh.tour',
            'hdv',
        ])
            ->where('id', $id)
            ->whereJsonContains('hdv_ids', (string) $hdvId)
            ->firstOrFail();

        // Lấy danh sách phương tiện
        $ids = $tour->phuong_tien_ids ?? [];

        if (!is_array($ids)) {
            $ids = json_decode($ids, true) ?? [];
        }

        $tour->dsPhuongTien = PhuongTien::whereIn('id', $ids)->get();

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
