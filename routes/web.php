<?php

use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\QuyenHanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaiTroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
// Client routes
Route::get('/', function () {
    return view('Client.trang_chu.index');
});

Route::get('/bai_viet', function(){
    return view('Client.bai_viet.index');
});
Route::get('/{id}/bai_viet', function(){
    return view('Client.bai_viet.detail');
})->name('bai_viet.detail');


Route::get('/demo', function () {
    return view('Client.demo');
});
Route::get('/trang_chu', function () {
    return view('Client.trang_chu.index');
});
Route::get('/ve_chung_toi', function () {
    return view('Client.ve_chung_toi.index');
});


Route::get('/danh_sach_tour_yeu_thich', function () {
    return view('Client.danh_sach_tour_yeu_thich.index');
});
Route::get('/dieu_khoan', function () {
    return view('Client.dieu_khoan.index');
});
// Auth routes
use App\Http\Controllers\AuthController;
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Login ADMIN
Route::prefix('Admin')->name('Admin.')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.admin');
    })->name('dashboard');
// Admin routes
    Route::resource('users', UserController::class);
    // Route::resource('vai-tros', VaiTroController::class);
    // Route::resource('quyen-hans', QuyenHanController::class);
    Route::resource('khach-hang', KhachHangDatTourController::class);
    Route::resource('huong-dan-viens', HuongDanVienController::class);
});

// Login Guide
Route::prefix('Guide')->name('Guide.')->middleware(['auth', \App\Http\Middleware\IsGuide::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.guide');
    })->name('dashboard');
//Guide routes
});

