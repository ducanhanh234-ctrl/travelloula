<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DanhSachTour;
use App\Models\DanhSachTourYeuThich;

class TourYeuThichController extends Controller
{
    public function index()
    {
        $favorites = DanhSachTourYeuThich::with([
            'tour.danhMuc',
            'tour.lichKhoiHanhTours',
        ])
            ->where('nguoi_dung_id', auth()->id())
            ->latest()
            ->paginate(6);

        return view('Client.danh_sach_tour_yeu_thich.index', compact('favorites'));
    }

    public function store($tourId)
    {
        $tour = DanhSachTour::where('trang_thai', 'active')
            ->findOrFail($tourId);

        $favorite = DanhSachTourYeuThich::where('nguoi_dung_id', auth()->id())
            ->where('tour_id', $tour->id)
            ->first();

        if ($favorite) {
            return back()->with('success', 'Tour này đã có trong danh sách yêu thích.');
        }

        DanhSachTourYeuThich::create([
            'nguoi_dung_id' => auth()->id(),
            'tour_id' => $tour->id,
        ]);

        return back()->with('success', 'Đã thêm tour vào danh sách yêu thích.');
    }

    public function destroy($tourId)
    {
        DanhSachTourYeuThich::where('nguoi_dung_id', auth()->id())
            ->where('tour_id', $tourId)
            ->delete();

        return back()->with('success', 'Đã xóa tour khỏi danh sách yêu thích.');
    }
}