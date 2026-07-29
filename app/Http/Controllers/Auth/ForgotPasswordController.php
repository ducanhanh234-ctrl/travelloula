<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Hiển thị trang nhập email.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Gửi liên kết đặt lại mật khẩu.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ email.',
                'email.email' => 'Địa chỉ email không đúng định dạng.',
            ]
        );

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'success',
                'Liên kết đặt lại mật khẩu đã được gửi tới email của bạn.'
            );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Không tìm thấy tài khoản sử dụng địa chỉ email này.',
            ]);
    }
}
