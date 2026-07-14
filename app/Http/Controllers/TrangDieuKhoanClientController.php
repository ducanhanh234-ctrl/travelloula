<?php

namespace App\Http\Controllers;

use App\Models\TrangDieuKhoan;
use Illuminate\Http\Request;

class TrangDieuKhoanClientController extends Controller
{
     public function index()
    {
        $trangDieuKhoan = TrangDieuKhoan::where('duong_dan', 'dieu-khoan')
            ->where('trang_thai', 1)
            ->firstOrFail();

        return view('Client.dieu_khoan.index', compact('trangDieuKhoan'));
    }
}
