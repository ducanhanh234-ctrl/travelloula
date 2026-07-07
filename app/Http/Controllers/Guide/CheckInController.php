<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\DatTour;
use App\Models\LichKhoiHanhTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    public function index()
    {
        $lichKhoiHanhs = LichKhoiHanhTour::with('tour')
            ->orderBy('ngay_khoi_hanh', 'desc')
            ->get();

        return view('Guide.checkin.index', compact('lichKhoiHanhs'));
    }

    public function show($lichKhoiHanhId)
    {
        $datTours = DatTour::with([
            'nguoiDung',
            'khachHangs'
        ])
            ->where('lich_khoi_hanh_id', $lichKhoiHanhId)
            ->get();

        return view('Guide.checkin.show', compact('datTours'));
    }
}
