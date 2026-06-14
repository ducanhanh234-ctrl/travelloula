<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(){ return view('auth.register'); }

    public function register(Request $request){
        $data = $request->validate([
            'name'=>'required|max:255','email'=>'required|email|unique:users,email','password'=>'required|min:6',
            'phone'=>'nullable|max:20','address'=>'nullable|max:255'
        ]);

        // Public registrations are treated as customers and saved as client accounts
        $user = User::create([
            'name'=>$data['name'],'email'=>$data['email'],'password'=>Hash::make($data['password']),
            'phone'=>$data['phone'] ?? null,'address'=>$data['address'] ?? null,'is_active'=>true
        ]);

        return redirect()->route('login')->with('success','Đăng ký thành công. Bạn có thể đăng nhập bằng tài khoản khách hàng.');
    }

    public function showLogin(){ return view('auth.login'); }

    public function login(Request $request){
        $credentials = $request->validate(['email'=>'required|email','password'=>'required']);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email'=>'Thông tin đăng nhập không đúng'])->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->intended(route('Admin.dashboard'));
        }

        if ($user->isGuide()) {
            return redirect()->intended(route('guide.dashboard'));
        }

        return redirect()->intended('/trang_chu');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
