<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('vaiTros')->latest()->paginate(10);
        return view('Admin.users.index', compact('users'));
    }
    public function create()
    {
        $vaiTros = VaiTro::all();
        return view('Admin.users.create', compact('vaiTros'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:255',
            'vai_tro_ids' => 'array',
            'is_active' => 'required|integer|in:1,2,3'
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => (int)$data['is_active']
        ]);
        $user->vaiTros()->sync($data['vai_tro_ids'] ?? []);
        return redirect()->route('Admin.users.index')->with('success', 'Đã tạo tài khoản');
    }
    public function edit(User $user)
    {
        $vaiTros = VaiTro::all();
        $user->load('vaiTros');
        return view('Admin.users.edit', compact('user', 'vaiTros'));
    }
    public function show(User $user)
    {
        $user->load('vaiTros');
        return view('Admin.users.show', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:255',
            'vai_tro_ids' => 'array',
            'is_active' => 'required|integer|in:1,2,3'
        ]);
        $payload = ['name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'] ?? null, 'address' => $data['address'] ?? null, 'is_active' => (int)$data['is_active']];
        if (!empty($data['password'])) $payload['password'] = Hash::make($data['password']);
        $user->update($payload);
        $user->vaiTros()->sync($data['vai_tro_ids'] ?? []);
        return redirect()->route('Admin.users.index')->with('success', 'Đã cập nhật tài khoản');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Đã xóa tài khoản');
    }
}
