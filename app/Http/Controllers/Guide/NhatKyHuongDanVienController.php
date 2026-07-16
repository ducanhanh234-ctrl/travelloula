<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\HuongDanVien;
use App\Models\NhatKyHuongDanVien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NhatKyHuongDanVienController extends Controller
{
    //hiển thị danh sách nhật ký của hướng dẫn viên
    public function index(Request $request)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $query = NhatKyHuongDanVien::with([
            'khachHang',
            'chiTiet.lichTrinh.tour'
        ])
            ->where(
                'huong_dan_vien_id',
                $guide->id
            );

        // Tìm theo tên khách
        if ($request->filled('keyword')) {

            $query->whereHas('khachHang', function ($q) use ($request) {

                $q->where(
                    'ho_ten',
                    'like',
                    '%' . $request->keyword . '%'
                );
            });
        }

        // Lọc theo hành động
        if ($request->filled('hanh_dong')) {

            $query->where(
                'hanh_dong',
                $request->hanh_dong
            );
        }

        $logs = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $tongHoatDong = $logs->total();

        $tongCheckIn = $logs
            ->where('hanh_dong', 'Check-in')
            ->count();

        $tongCheckOut = $logs
            ->where('hanh_dong', 'Check-out')
            ->count();

        return view(
            'Guide.nhatky.index',
            compact(
                'logs',
                'tongHoatDong',
                'tongCheckIn',
                'tongCheckOut'
            )
        );
    }

    public function show($id)
    {
        $guide = HuongDanVien::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $log = NhatKyHuongDanVien::with([
            'khachHang',
            'chiTiet.lichTrinh.tour',
            'huongDanVien'
        ])
            ->where('huong_dan_vien_id', $guide->id)
            ->findOrFail($id);

        return view(
            'Guide.nhatky.show',
            compact('log')
        );
    }
}
