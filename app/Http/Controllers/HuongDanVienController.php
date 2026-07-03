<?php

namespace App\Http\Controllers;

use App\Models\HuongDanVien;
use App\Models\User;
use App\Models\VaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HuongDanVienController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:guides.view')->only(['index', 'show']);
        $this->middleware('permission:guides.create')->only(['create', 'store']);
        $this->middleware('permission:guides.edit')->only(['edit', 'update']);
        $this->middleware('permission:guides.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = HuongDanVien::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('ho_ten', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('so_dien_thoai', 'like', '%' . $keyword . '%')
                    ->orWhere('so_cccd', 'like', '%' . $keyword . '%')
                    ->orWhere('ngon_ngu_thanh_thao', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('kinh_nghiem')) {
            if ($request->kinh_nghiem == '0_1') {
                $query->whereBetween('so_nam_kinh_nghiem', [0, 1]);
            } elseif ($request->kinh_nghiem == '2_5') {
                $query->whereBetween('so_nam_kinh_nghiem', [2, 5]);
            } elseif ($request->kinh_nghiem == '6_plus') {
                $query->where('so_nam_kinh_nghiem', '>=', 6);
            }
        }

        $guides = $query->latest()
            ->paginate(12)
            ->withQueryString();

        return view('Admin.huong_dan_viens.index', compact('guides'));
    }

    public function create()
    {
        return view('Admin.huong_dan_viens.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:huong_dan_viens,email|unique:users,email',
            'password' => 'required|string|min:6',

            'so_cccd' => 'nullable|string|max:20',
            'ngay_cap_cccd' => 'nullable|date',
            'noi_cap_cccd' => 'nullable|string|max:255',
            'anh_cccd_truoc' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'anh_cccd_sau' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'so_dien_thoai' => 'nullable|string|max:20',
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'nullable|in:nam,nu,khac',
            'dia_chi' => 'nullable|string|max:500',
            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'so_nam_kinh_nghiem' => 'nullable|integer|min:0',
            'ngon_ngu_thanh_thao' => 'nullable|string|max:255',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|in:hoat_dong,san_sang,dang_dan_tour,khong_hoat_dong,bi_khoa,nghi_viec',
        ]);

        if ($request->hasFile('anh_dai_dien')) {
            $data['anh_dai_dien'] = $request->file('anh_dai_dien')
                ->store('huong-dan-viens/avatar', 'public');
        }

        if ($request->hasFile('anh_cccd_truoc')) {
            $data['anh_cccd_truoc'] = $request->file('anh_cccd_truoc')
                ->store('huong-dan-viens/cccd', 'public');
        }

        if ($request->hasFile('anh_cccd_sau')) {
            $data['anh_cccd_sau'] = $request->file('anh_cccd_sau')
                ->store('huong-dan-viens/cccd', 'public');
        }

        $user = User::create([
            'name' => $data['ho_ten'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['so_dien_thoai'] ?? null,
            'address' => $data['dia_chi'] ?? null,
            'is_active' => true,
        ]);

        unset($data['password']);

        $guide = HuongDanVien::create(array_merge($data, [
            'user_id' => $user->id,
        ]));

        $role = VaiTro::firstOrCreate(
            ['ten_vai_tro' => 'guide'],
            ['mo_ta' => 'Hướng dẫn viên']
        );

        $user->vaiTros()->syncWithoutDetaching([$role->id]);

        return redirect()
            ->route('Admin.huong-dan-viens.index')
            ->with('success', 'Đã tạo hướng dẫn viên và tài khoản đăng nhập.');
    }

    public function show(HuongDanVien $huongDanVien)
    {
        return view('Admin.huong_dan_viens.show', compact('huongDanVien'));
    }

    public function edit(HuongDanVien $huongDanVien)
    {
        return view('Admin.huong_dan_viens.edit', compact('huongDanVien'));
    }

    public function update(Request $request, HuongDanVien $huongDanVien)
    {
        $data = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:huong_dan_viens,email,' . $huongDanVien->id . '|unique:users,email,' . optional($huongDanVien->user)->id,
            'password' => 'nullable|string|min:6',

            'so_cccd' => 'nullable|string|max:20',
            'ngay_cap_cccd' => 'nullable|date',
            'noi_cap_cccd' => 'nullable|string|max:255',
            'anh_cccd_truoc' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'anh_cccd_sau' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'so_dien_thoai' => 'nullable|string|max:20',
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'nullable|in:nam,nu,khac',
            'dia_chi' => 'nullable|string|max:500',
            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'so_nam_kinh_nghiem' => 'nullable|integer|min:0',
            'ngon_ngu_thanh_thao' => 'nullable|string|max:255',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|in:hoat_dong,san_sang,dang_dan_tour,khong_hoat_dong,bi_khoa,nghi_viec',
        ]);

        if ($request->hasFile('anh_dai_dien')) {
            if ($huongDanVien->anh_dai_dien && Storage::disk('public')->exists($huongDanVien->anh_dai_dien)) {
                Storage::disk('public')->delete($huongDanVien->anh_dai_dien);
            }

            $data['anh_dai_dien'] = $request->file('anh_dai_dien')
                ->store('huong-dan-viens/avatar', 'public');
        } else {
            unset($data['anh_dai_dien']);
        }

        if ($request->hasFile('anh_cccd_truoc')) {
            if ($huongDanVien->anh_cccd_truoc && Storage::disk('public')->exists($huongDanVien->anh_cccd_truoc)) {
                Storage::disk('public')->delete($huongDanVien->anh_cccd_truoc);
            }

            $data['anh_cccd_truoc'] = $request->file('anh_cccd_truoc')
                ->store('huong-dan-viens/cccd', 'public');
        } else {
            unset($data['anh_cccd_truoc']);
        }

        if ($request->hasFile('anh_cccd_sau')) {
            if ($huongDanVien->anh_cccd_sau && Storage::disk('public')->exists($huongDanVien->anh_cccd_sau)) {
                Storage::disk('public')->delete($huongDanVien->anh_cccd_sau);
            }

            $data['anh_cccd_sau'] = $request->file('anh_cccd_sau')
                ->store('huong-dan-viens/cccd', 'public');
        } else {
            unset($data['anh_cccd_sau']);
        }

        $password = $data['password'] ?? null;
        unset($data['password']);

        $huongDanVien->update($data);

        if ($huongDanVien->user) {
            $userData = [
                'name' => $data['ho_ten'],
                'email' => $data['email'],
                'phone' => $data['so_dien_thoai'] ?? null,
                'address' => $data['dia_chi'] ?? null,
            ];

            if (!empty($password)) {
                $userData['password'] = Hash::make($password);
            }

            $huongDanVien->user->update($userData);
        }

        return redirect()
            ->route('Admin.huong-dan-viens.index')
            ->with('success', 'Đã cập nhật hướng dẫn viên.');
    }

    public function destroy(HuongDanVien $huongDanVien)
    {
        if ($huongDanVien->anh_dai_dien && Storage::disk('public')->exists($huongDanVien->anh_dai_dien)) {
            Storage::disk('public')->delete($huongDanVien->anh_dai_dien);
        }

        if ($huongDanVien->anh_cccd_truoc && Storage::disk('public')->exists($huongDanVien->anh_cccd_truoc)) {
            Storage::disk('public')->delete($huongDanVien->anh_cccd_truoc);
        }

        if ($huongDanVien->anh_cccd_sau && Storage::disk('public')->exists($huongDanVien->anh_cccd_sau)) {
            Storage::disk('public')->delete($huongDanVien->anh_cccd_sau);
        }

        if ($huongDanVien->user) {
            $huongDanVien->user->delete();
        }

        $huongDanVien->delete();

        return redirect()
            ->route('Admin.huong-dan-viens.index')
            ->with('success', 'Đã xóa hướng dẫn viên và tài khoản liên quan.');
    }
}
