<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== REGISTER =====
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:255',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('login')
            ->with('success', 'Đăng ký thành công. Bạn có thể đăng nhập.');
    }

    // ===== LOGIN =====
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email hoặc mật khẩu không đúng'])
                ->withInput();
        }

        $request->session()->regenerate();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || !$user->is_active) {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.']);
        }

        if ($user->hasPermission('vao_admin')) {
            return redirect()->intended(route('Admin.dashboard'));
        }

        if ($user->hasPermission('vao_guide')) {
            return redirect()->intended(route('Guide.dashboard'));
        }

        return redirect()->intended('/trang_chu');
    }

    // ===== LOGOUT =====
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
