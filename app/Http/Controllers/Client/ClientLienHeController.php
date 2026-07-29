<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\LienHe;
use Illuminate\Http\Request;

class ClientLienHeController extends Controller
{
    /**
     * Hiển thị trang liên hệ
     */
    public function index()
    {
        return view('Client.lien_he.index');
    }

    /**
     * Lưu liên hệ
     */
    public function store(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'so_dien_thoai' => [
                'required',
                'regex:/^(0|\+84)[0-9]{9,10}$/'
            ],
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string|min:10|max:3000',
        ],[
            'ho_ten.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',

            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
            'so_dien_thoai.regex' => 'Số điện thoại không hợp lệ.',

            'tieu_de.required' => 'Vui lòng nhập tiêu đề.',

            'noi_dung.required' => 'Vui lòng nhập nội dung.',
            'noi_dung.min' => 'Nội dung tối thiểu 10 ký tự.',
        ]);

        LienHe::create([
            'ho_ten'         => $request->ho_ten,
            'email'          => $request->email,
            'so_dien_thoai'  => $request->so_dien_thoai,
            'tieu_de'        => $request->tieu_de,
            'noi_dung'       => $request->noi_dung,
            'trang_thai'     => 'Chưa xử lý',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Cảm ơn bạn đã liên hệ với Travelloula. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    }
}