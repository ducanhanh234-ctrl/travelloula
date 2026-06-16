<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DatTour;
use Illuminate\Http\Request;
use App\Models\DanhSachTour;
use App\Models\LichKhoiHanhTour;

class DatTourController extends Controller
{
    public function index()
    {
        $bookings = DatTour::with([
            'tour',
            'user',
            'lichKhoiHanh.huongDanVien'
        ])->latest()->paginate(10)->withQueryString();

        return view(
            'Admin.dat_tours.index',
            compact('bookings')
        );
    }

    public function create()
    {
        $tours = DanhSachTour::where('trang_thai', 'active')->get();

        $lichKhoiHanhs = LichKhoiHanhTour::where('trang_thai', 'available')
            ->get();

        return view(
            'Admin.dat_tours.create',
            compact('tours', 'lichKhoiHanhs')
        );
    }

    public function updateStatus(Request $request, DatTour $booking)
    {
        $data = $request->validate([
            'trang_thai' => ['required', 'in:cho_xac_nhan,da_xac_nhan,da_thanh_toan,da_huy,hoan_thanh'],
        ]);

        $booking->update([
            'trang_thai' => $data['trang_thai'],
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái booking.');
    }
}
