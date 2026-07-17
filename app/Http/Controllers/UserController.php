<?php

namespace App\Http\Controllers;

use App\Models\HuongDanVien;
use App\Models\User;
use App\Models\VaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.view')->only(['index', 'show']);
        $this->middleware('permission:users.create')->only(['create', 'store']);
        $this->middleware('permission:users.edit')->only(['edit', 'update']);
        $this->middleware('permission:users.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = User::with('vaiTros');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('vai_tro_id')) {
            $query->whereHas('vaiTros', function ($q) use ($request) {
                $q->where('vai_tros.id', $request->vai_tro_id);
            });
        }

        $users = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $vaiTros = VaiTro::orderBy('ten_vai_tro')->get();

        return view('Admin.users.index', compact('users', 'vaiTros'));
    }

    public function create()
    {
        $vaiTros = VaiTro::orderBy('ten_vai_tro')->get();

        return view('Admin.users.create', compact('vaiTros'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'vai_tro_id' => 'required|exists:vai_tros,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => 1,
        ]);

        $user->vaiTros()->sync([$data['vai_tro_id']]);
        $user->save();

        $this->syncGuideRecord($user, $data['vai_tro_id']);

        return redirect()
            ->route('Admin.users.index')
            ->with('success', 'Đã tạo tài khoản');
    }

    public function show(User $user)
    {
        $user->load('vaiTros');

        return view('Admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $vaiTros = VaiTro::orderBy('ten_vai_tro')->get();
        $user->load('vaiTros');

        return view('Admin.users.edit', compact('user', 'vaiTros'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'vai_tro_id' => 'required|exists:vai_tros,id',
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);

        $user->vaiTros()->sync([$data['vai_tro_id']]);
        $user->save();

        $this->syncGuideRecord($user, $data['vai_tro_id']);

        return redirect()
            ->route('Admin.users.index')
            ->with('success', 'Đã cập nhật tài khoản');
    }

    protected function syncGuideRecord(User $user, int $roleId): void
    {
        $role = VaiTro::find($roleId);
        if (!$role) {
            return;
        }

        $isGuideRole = strtolower($role->ten_vai_tro ?? '') === 'guide';
        if (!$isGuideRole) {
            return;
        }

        HuongDanVien::updateOrCreate(
            ['user_id' => $user->id],
            [
                'ho_ten' => $user->name ?? 'Hướng dẫn viên',
                'email' => $user->email,
                'so_dien_thoai' => $user->phone,
                'dia_chi' => $user->address,
                'trang_thai' => 'san_sang',
            ]
        );
    }

    public function destroy(User $user)
    {
        $user->vaiTros()->detach();
        $user->delete();

        return redirect()
            ->route('Admin.users.index')
            ->with('success', 'Đã xóa tài khoản');
    }
}
