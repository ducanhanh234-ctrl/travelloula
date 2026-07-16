<?php

namespace App\Http\Controllers;

use App\Models\HuongDanVien;
use App\Models\User;
use App\Models\VaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            $keyword = trim((string) $request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('ho_ten', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('so_dien_thoai', 'like', "%{$keyword}%")
                    ->orWhere('so_cccd', 'like', "%{$keyword}%")
                    ->orWhere('ngon_ngu_thanh_thao', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('kinh_nghiem')) {
            switch ($request->kinh_nghiem) {
                case '0_1':
                    $query->whereBetween('so_nam_kinh_nghiem', [0, 1]);
                    break;

                case '2_5':
                    $query->whereBetween('so_nam_kinh_nghiem', [2, 5]);
                    break;

                case '6_plus':
                    $query->where('so_nam_kinh_nghiem', '>=', 6);
                    break;
            }
        }

        $guides = $query->latest('id')
            ->paginate(12)
            ->withQueryString();

        $tongHDV = HuongDanVien::count();
        $sanSang = HuongDanVien::where('trang_thai', 'san_sang')->count();
        $dangDanTour = HuongDanVien::where('trang_thai', 'dang_dan_tour')->count();
        $nghiViec = HuongDanVien::where('trang_thai', 'nghi_viec')->count();

        return view('Admin.huong_dan_viens.index', compact(
            'guides',
            'tongHDV',
            'sanSang',
            'dangDanTour',
            'nghiViec'
        ));
    }

    public function create()
    {
        return view('Admin.huong_dan_viens.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());

        $uploadedFiles = [];

        try {
            DB::transaction(function () use ($request, &$data, &$uploadedFiles) {
                $this->storeUploadedFiles($request, $data, $uploadedFiles);

                $user = User::create([
                    'name' => $data['ho_ten'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'phone' => $data['so_dien_thoai'] ?? null,
                    'address' => $data['dia_chi'] ?? null,
                    'is_active' => true,
                ]);

                unset($data['password']);

                HuongDanVien::create(array_merge($data, [
                    'user_id' => $user->id,
                ]));

                $role = VaiTro::firstOrCreate(
                    ['ten_vai_tro' => 'guide'],
                    ['mo_ta' => 'Hướng dẫn viên']
                );

                $user->vaiTros()->syncWithoutDetaching([$role->id]);
            });
        } catch (\Throwable $exception) {
            foreach ($uploadedFiles as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $exception;
        }

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
        $data = $request->validate($this->validationRules($huongDanVien));
        $oldFiles = [];
        $newFiles = [];
        $password = $data['password'] ?? null;
        unset($data['password']);

        try {
            DB::transaction(function () use (
                $request,
                $huongDanVien,
                &$data,
                &$oldFiles,
                &$newFiles,
                $password
            ) {
                $this->replaceUploadedFiles(
                    $request,
                    $huongDanVien,
                    $data,
                    $oldFiles,
                    $newFiles
                );

                $huongDanVien->update($data);

                $userData = [
                    'name' => $data['ho_ten'],
                    'email' => $data['email'],
                    'phone' => $data['so_dien_thoai'] ?? null,
                    'address' => $data['dia_chi'] ?? null,
                    'is_active' => !in_array(
                        $data['trang_thai'],
                        ['khong_hoat_dong', 'bi_khoa', 'nghi_viec'],
                        true
                    ),
                ];

                if (!empty($password)) {
                    $userData['password'] = Hash::make($password);
                }

                if ($huongDanVien->user) {
                    $huongDanVien->user->update($userData);
                } else {
                    $userData['password'] = Hash::make($password ?: '12345678');
                    $user = User::create($userData);

                    $huongDanVien->update(['user_id' => $user->id]);

                    $role = VaiTro::firstOrCreate(
                        ['ten_vai_tro' => 'guide'],
                        ['mo_ta' => 'Hướng dẫn viên']
                    );

                    $user->vaiTros()->syncWithoutDetaching([$role->id]);
                }
            });
        } catch (\Throwable $exception) {
            foreach ($newFiles as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $exception;
        }

        foreach ($oldFiles as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()
            ->route('Admin.huong-dan-viens.index')
            ->with('success', 'Đã cập nhật hướng dẫn viên.');
    }

    public function destroy(HuongDanVien $huongDanVien)
    {
        $files = array_filter([
            $huongDanVien->anh_dai_dien,
            $huongDanVien->anh_cccd_truoc,
            $huongDanVien->anh_cccd_sau,
        ]);

        DB::transaction(function () use ($huongDanVien) {
            $user = $huongDanVien->user;

            $huongDanVien->delete();

            if ($user) {
                $user->delete();
            }
        });

        foreach ($files as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()
            ->route('Admin.huong-dan-viens.index')
            ->with('success', 'Đã xóa hướng dẫn viên và tài khoản liên quan.');
    }

    private function validationRules(?HuongDanVien $huongDanVien = null): array
    {
        $guideId = $huongDanVien?->id;
        $userId = $huongDanVien?->user?->id;

        return [
            'ho_ten' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('huong_dan_viens', 'email')->ignore($guideId),
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => [$huongDanVien ? 'nullable' : 'required', 'string', 'min:6'],
            'so_cccd' => ['nullable', 'string', 'max:20'],
            'ngay_cap_cccd' => ['nullable', 'date'],
            'noi_cap_cccd' => ['nullable', 'string', 'max:255'],
            'anh_cccd_truoc' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'anh_cccd_sau' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'ngay_sinh' => ['nullable', 'date'],
            'gioi_tinh' => ['nullable', Rule::in(['nam', 'nu', 'khac'])],
            'dia_chi' => ['nullable', 'string', 'max:500'],
            'anh_dai_dien' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'so_nam_kinh_nghiem' => ['nullable', 'integer', 'min:0'],
            'ngon_ngu_thanh_thao' => ['nullable', 'string', 'max:255'],
            'mo_ta' => ['nullable', 'string'],
            'trang_thai' => [
                'required',
                Rule::in([
                    'hoat_dong',
                    'san_sang',
                    'dang_dan_tour',
                    'khong_hoat_dong',
                    'bi_khoa',
                    'nghi_viec',
                ]),
            ],
        ];
    }

    private function storeUploadedFiles(Request $request, array &$data, array &$uploadedFiles): void
    {
        $fileMap = [
            'anh_dai_dien' => 'huong-dan-viens/avatar',
            'anh_cccd_truoc' => 'huong-dan-viens/cccd',
            'anh_cccd_sau' => 'huong-dan-viens/cccd',
        ];

        foreach ($fileMap as $field => $directory) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store($directory, 'public');
                $data[$field] = $path;
                $uploadedFiles[] = $path;
            }
        }
    }

    private function replaceUploadedFiles(
        Request $request,
        HuongDanVien $huongDanVien,
        array &$data,
        array &$oldFiles,
        array &$newFiles
    ): void {
        $fileMap = [
            'anh_dai_dien' => 'huong-dan-viens/avatar',
            'anh_cccd_truoc' => 'huong-dan-viens/cccd',
            'anh_cccd_sau' => 'huong-dan-viens/cccd',
        ];

        foreach ($fileMap as $field => $directory) {
            if (!$request->hasFile($field)) {
                unset($data[$field]);
                continue;
            }

            $path = $request->file($field)->store($directory, 'public');
            $data[$field] = $path;
            $newFiles[] = $path;

            if (!empty($huongDanVien->{$field})) {
                $oldFiles[] = $huongDanVien->{$field};
            }
        }
    }
}
