<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Hiển thị hồ sơ cá nhân.
     */
    public function show()
    {
        $user = Auth::user();

        return view('client.profile.show', compact('user'));
    }

    /**
     * Hiển thị form cập nhật hồ sơ.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('client.profile.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin cá nhân.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'phone' => [
                    'nullable',
                    'regex:/^(0|\+84)[0-9]{9}$/',
                    'unique:users,phone,' . $user->id,
                ],
                'address' => [
                    'nullable',
                    'string',
                    'max:500',
                ],
                'avatar' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],
            ],
            [
                'name.required' => 'Vui lòng nhập họ và tên.',
                'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

                'phone.regex' => 'Số điện thoại không đúng định dạng.',
                'phone.unique' => 'Số điện thoại đã được sử dụng.',

                'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',

                'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
                'avatar.mimes' => 'Ảnh đại diện chỉ hỗ trợ JPG, JPEG, PNG hoặc WEBP.',
                'avatar.max' => 'Ảnh đại diện không được vượt quá 2 MB.',
            ]
        );

        if ($request->hasFile('avatar')) {
            if (
                $user->avatar &&
                Storage::disk('public')->exists($user->avatar)
            ) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request
                ->file('avatar')
                ->store('avatars/customers', 'public');
        }

        $user->update($validated);

        return redirect()
            ->route('client.profile.show')
            ->with('success', 'Cập nhật hồ sơ cá nhân thành công.');
    }

    /**
     * Hiển thị form đổi mật khẩu.
     */
    public function showChangePasswordForm()
    {
        return view('client.profile.change-password');
    }

    /**
     * Cập nhật mật khẩu.
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate(
            [
                'current_password' => [
                    'required',
                    'current_password',
                ],
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->numbers(),
                ],
            ],
            [
                'current_password.required' =>
                    'Vui lòng nhập mật khẩu hiện tại.',

                'current_password.current_password' =>
                    'Mật khẩu hiện tại không chính xác.',

                'password.required' =>
                    'Vui lòng nhập mật khẩu mới.',

                'password.confirmed' =>
                    'Xác nhận mật khẩu mới không khớp.',

                'password.min' =>
                    'Mật khẩu mới phải có ít nhất 8 ký tự.',
            ]
        );

        $user->update([
            'password' => $request->password,
        ]);

        return redirect()
            ->route('client.profile.show')
            ->with('success', 'Đổi mật khẩu thành công.');
    }

    /**
     * Xóa ảnh đại diện.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if (
            $user->avatar &&
            Storage::disk('public')->exists($user->avatar)
        ) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update([
            'avatar' => null,
        ]);

        return back()->with(
            'success',
            'Đã xóa ảnh đại diện.'
        );
    }
}
