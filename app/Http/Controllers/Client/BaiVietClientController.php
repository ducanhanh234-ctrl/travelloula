<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;

class BaiVietClientController extends Controller
{
    public function index()
    {
        $baiViets = BaiViet::where('trang_thai', 1)
            ->latest()
            ->paginate(9);

        return view('Client.bai_viet.index', compact('baiViets'));
    }

    public function show($duongDan)
    {
        $baiViet = BaiViet::where('duong_dan', $duongDan)
            ->where('trang_thai', 1)
            ->firstOrFail();

        $baiViet->increment('luot_xem');

        $baiVietLienQuan = BaiViet::where('trang_thai', 1)
            ->where('id', '!=', $baiViet->id)
            ->latest()
            ->take(4)
            ->get();

        return view('Client.bai_viet.detail', compact('baiViet', 'baiVietLienQuan'));
    }
}