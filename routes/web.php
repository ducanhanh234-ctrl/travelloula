<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Admin\LichKhoiHanhController;
use App\Http\Controllers\Admin\GopDoanController;


/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', function () {
    return view('Client.trang_chu.index');
})->name('home');

Route::get('/trang_chu', function () {
    return view('Client.trang_chu.index');
});

Route::get('/ve_chung_toi', function () {
    return view('Client.ve_chung_toi.index');
});

Route::get('/bai_viet', function () {
    return view('Client.bai_viet.index');
});

Route::get('/{id}/bai_viet', function () {
    return view('Client.bai_viet.detail');
})->name('bai_viet.detail');

Route::get('/danh_sach_tour_yeu_thich', function () {
    return view('Client.danh_sach_tour_yeu_thich.index');
});

Route::get('/dieu_khoan', function () {
    return view('Client.dieu_khoan.index');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('Admin')
    ->name('Admin.')
    ->middleware([
        'auth',
        \App\Http\Middleware\IsAdmin::class
    ])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', function () {
            return view('Layouts.admin');
        })->name('dashboard');



        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'users',
            UserController::class
        );



        /*
        |--------------------------------------------------------------------------
        | KHÁCH HÀNG
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'khach-hang',
            KhachHangDatTourController::class
        );



        /*
        |--------------------------------------------------------------------------
        | HƯỚNG DẪN VIÊN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'huong-dan-viens',
            HuongDanVienController::class
        );



        /*
        |--------------------------------------------------------------------------
        | LỊCH KHỞI HÀNH
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'lich-khoi-hanh',
            LichKhoiHanhController::class
        );



        /*
        |--------------------------------------------------------------------------
        | GỘP ĐOÀN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'gop-doan',
            GopDoanController::class
        );


        // Hủy yêu cầu gộp đoàn
        Route::post(
            'gop-doan/{id}/huy',
            [
                GopDoanController::class,
                'destroy'
            ]
        )->name('gop-doan.huy');

        Route::post(
            'gop-doan/chi-tiet/{id}/trang-thai',
            [
                GopDoanController::class,
                'capNhatTrangThaiLienHe'
            ]
        )
            ->name('gop-doan.cap-nhat-trang-thai');

        Route::post(
            'gop-doan/{id}/chot',
            [
                GopDoanController::class,
                'chotGop'
            ]
        )->name('gop-doan.chot');
    });



/*
|--------------------------------------------------------------------------
| GUIDE ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('Guide')
    ->name('Guide.')
    ->middleware(['auth', \App\Http\Middleware\IsGuide::class])
    ->group(function () {

        Route::get('/', function () {
            return view('Layouts.guide');
        })->name('dashboard');
    });
