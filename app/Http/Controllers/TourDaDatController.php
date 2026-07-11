<?php

namespace App\Http\Controllers;

use App\Models\DatTour;
use Illuminate\Http\Request;

class TourDaDatController extends Controller
{
    public function index()
{
    $datTours = DatTour::with([
        'tour',
        'lichKhoiHanh'
    ])
    ->where('nguoi_dung_id', auth()->id())
    ->latest()
    ->get();

    return view('client.tour_da_dat.index', compact('datTours'));
}
public function show($id)
{
    $datTour = DatTour::with([
        'tour',
        'lichKhoiHanh',
        'thanhToans',
        'khachHangs'
    ])
    ->where('nguoi_dung_id', auth()->id())
    ->findOrFail($id);

    return view('client.tour_da_dat.show', compact('datTour'));
}
public function destroy($id)
{
    $datTour = DatTour::where('nguoi_dung_id', auth()->id())
        ->findOrFail($id);

    // Không cho hủy nếu đã thanh toán
    if ($datTour->trang_thai == 'da_thanh_toan') {
        return back()->with('error', 'Tour đã thanh toán nên không thể hủy.');
    }

    // Nếu có thanh toán thì xóa
    if ($datTour->thanhToan) {
        $datTour->thanhToans()->delete();
    }

    // Nếu có khách đi cùng
    if ($datTour->khachHangs()->exists()) {
        $datTour->khachHangs()->delete();
    }

    $datTour->forceDelete();

    return redirect()->route('tour_da_dat.index')
        ->with('success', 'Đã hủy đơn đặt tour.');
}
}
