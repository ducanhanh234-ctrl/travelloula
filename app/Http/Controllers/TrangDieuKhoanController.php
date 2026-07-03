<?php

namespace App\Http\Controllers;

use App\Models\TrangDieuKhoan;
use Illuminate\Http\Request;

class TrangDieuKhoanController extends Controller
{
    public function edit()
    {
        $trangDieuKhoan = TrangDieuKhoan::firstOrCreate(
            [
                'duong_dan' => 'dieu-khoan',
            ],
            [
                'tieu_de' => 'Điều khoản sử dụng',
                'noi_dung' => '',
                'trang_thai' => 1,
            ]
        );

        return view('Admin.trang_dieu_khoans.edit', compact('trangDieuKhoan'));
    }

    public function update(Request $request)
    {
        $trangDieuKhoan = TrangDieuKhoan::where('duong_dan', 'dieu-khoan')->firstOrFail();

        $data = $request->validate([
            'tieu_de' => 'required|max:255',
            'noi_dung' => 'nullable|string',
            'trang_thai' => 'required|in:0,1',
        ]);

        $trangDieuKhoan->update([
            'tieu_de' => $data['tieu_de'],
            'noi_dung' => $data['noi_dung'] ?? null,
            'trang_thai' => $data['trang_thai'],
        ]);

        return redirect()
            ->route('Admin.trang_dieu_khoans.edit')
            ->with('success', 'Cập nhật trang điều khoản thành công.');
    }
}