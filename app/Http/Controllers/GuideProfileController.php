<?php

namespace App\Http\Controllers;

use App\Models\HuongDanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuideProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $huongDanVien = HuongDanVien::where('user_id', $user->id)->firstOrFail();

        return view('Guide.profileGuide', compact('huongDanVien'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $huongDanVien = HuongDanVien::where('user_id', $user->id)->firstOrFail();

        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('huong_dan_viens', 'email')->ignore($huongDanVien->id),
            ],

            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'dia_chi' => ['nullable', 'string', 'max:255'],
            'ngay_sinh' => ['nullable', 'date'],
            'gioi_tinh' => ['nullable', 'in:nam,nu,khac'],

            'so_cccd' => ['nullable', 'string', 'max:20'],
            'ngay_cap_cccd' => ['nullable', 'date'],
            'noi_cap_cccd' => ['nullable', 'string', 'max:255'],

            'so_nam_kinh_nghiem' => ['nullable', 'integer', 'min:0'],
            'ngon_ngu_thanh_thao' => ['nullable', 'string', 'max:255'],
            'mo_ta' => ['nullable', 'string'],

            'anh_dai_dien' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'anh_cccd_truoc' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'anh_cccd_sau' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if ($request->hasFile('anh_dai_dien')) {
            $data['anh_dai_dien'] = $request->file('anh_dai_dien')
                ->store('huong_dan_viens/avatar', 'public');
        }

        if ($request->hasFile('anh_cccd_truoc')) {
            $data['anh_cccd_truoc'] = $request->file('anh_cccd_truoc')
                ->store('huong_dan_viens/cccd', 'public');
        }

        if ($request->hasFile('anh_cccd_sau')) {
            $data['anh_cccd_sau'] = $request->file('anh_cccd_sau')
                ->store('huong_dan_viens/cccd', 'public');
        }

        $huongDanVien->update([
            'ho_ten' => $data['ho_ten'],
            'email' => $data['email'],
            'so_dien_thoai' => $data['so_dien_thoai'] ?? null,
            'dia_chi' => $data['dia_chi'] ?? null,
            'ngay_sinh' => $data['ngay_sinh'] ?? null,
            'gioi_tinh' => $data['gioi_tinh'] ?? null,

            'so_cccd' => $data['so_cccd'] ?? null,
            'ngay_cap_cccd' => $data['ngay_cap_cccd'] ?? null,
            'noi_cap_cccd' => $data['noi_cap_cccd'] ?? null,

            'so_nam_kinh_nghiem' => $data['so_nam_kinh_nghiem'] ?? 0,
            'ngon_ngu_thanh_thao' => $data['ngon_ngu_thanh_thao'] ?? null,
            'mo_ta' => $data['mo_ta'] ?? null,

            'anh_dai_dien' => $data['anh_dai_dien'] ?? $huongDanVien->anh_dai_dien,
            'anh_cccd_truoc' => $data['anh_cccd_truoc'] ?? $huongDanVien->anh_cccd_truoc,
            'anh_cccd_sau' => $data['anh_cccd_sau'] ?? $huongDanVien->anh_cccd_sau,
        ]);

        /*
         * Bảng huong_dan_viens là bảng hồ sơ chính.
         * Bảng users chỉ đồng bộ thông tin đăng nhập cơ bản.
         */
        $userUpdate = [
            'name' => $data['ho_ten'],
            'email' => $data['email'],
            'phone' => $data['so_dien_thoai'] ?? null,
            'address' => $data['dia_chi'] ?? null,
        ];

        if (!empty($data['password'])) {
            $userUpdate['password'] = Hash::make($data['password']);
        }

        $user->update($userUpdate);

        return redirect()
            ->route('Guide.profile')
            ->with('success', 'Cập nhật hồ sơ hướng dẫn viên thành công.');
    }
}
