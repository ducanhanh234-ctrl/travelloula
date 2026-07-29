<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ResetPasswordController extends Controller
{
    /**
     * Hiển thị trang nhập mật khẩu mới.
     */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Cập nhật mật khẩu mới.
     */
    public function reset(Request $request)
    {
        $request->validate(
            [
                'token' => ['required'],
                'email' => ['required', 'email'],
                'password' => [
                    'required',
                    'confirmed',
                    PasswordRule::min(8),
                ],
            ],
            [
                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không đúng định dạng.',

                'password.required' => 'Vui lòng nhập mật khẩu mới.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            ]
        );

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Đặt lại mật khẩu thành công. Bạn có thể đăng nhập bằng mật khẩu mới.'
                );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => match ($status) {
                    Password::INVALID_TOKEN =>
                        'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.',

                    Password::INVALID_USER =>
                        'Không tìm thấy tài khoản sử dụng email này.',

                    default =>
                        'Không thể đặt lại mật khẩu. Vui lòng thử lại.',
                },
            ]);
    }
}
