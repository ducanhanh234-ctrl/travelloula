<?php

namespace App\Http\Controllers;

use App\Models\TrangDieuKhoan;
use Illuminate\Http\Request;

class TrangDieuKhoanController extends Controller
{
    public function edit()
    {
        $trangDieuKhoan = TrangDieuKhoan::where('duong_dan', 'dieu-khoan')->first();

        if (!$trangDieuKhoan) {
            $trangDieuKhoan = TrangDieuKhoan::create([
                'tieu_de' => 'Điều khoản hoàn hủy tour du lịch',
                'duong_dan' => 'dieu-khoan',
                'noi_dung' => '',
                'trang_thai' => 1,
            ]);
        }

        return view('Admin.trang_dieu_khoans.edit', compact('trangDieuKhoan'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'nullable|string',
            'trang_thai' => 'required|in:0,1',
        ]);

        $trangDieuKhoan = TrangDieuKhoan::where('duong_dan', 'dieu-khoan')->first();

        if (!$trangDieuKhoan) {
            $trangDieuKhoan = new TrangDieuKhoan();
            $trangDieuKhoan->duong_dan = 'dieu-khoan';
        }

        $trangDieuKhoan->tieu_de = $data['tieu_de'];
        $trangDieuKhoan->noi_dung = $data['noi_dung'] ?? '';
        $trangDieuKhoan->trang_thai = $data['trang_thai'];
        $trangDieuKhoan->save();

        return redirect()
            ->route('Admin.trang_dieu_khoans.edit')
            ->with('success', 'Cập nhật trang điều khoản thành công.');
    }

    public function clientShow()
    {
        $trangDieuKhoan = TrangDieuKhoan::where('duong_dan', 'dieu-khoan')
            ->where('trang_thai', 1)
            ->first();

        if (!$trangDieuKhoan) {
            return view('Client.dieu_khoan.index', [
                'trangDieuKhoan' => null,
            ]);
        }

        return view('Client.dieu_khoan.index', compact('trangDieuKhoan'));
    }
}