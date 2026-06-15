<?php

use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\QuyenHanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaiTroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;

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
use App\Http\Controllers\PhuongTienController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('Admin')->name('Admin.')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.admin');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('vai-tros', VaiTroController::class);
    Route::resource('quyen-hans', QuyenHanController::class);
    Route::resource('khach-hang', KhachHangDatTourController::class);
    Route::resource('huong-dan-viens', HuongDanVienController::class);
    Route::resource('phuong-tiens', PhuongTienController::class);
});

Route::prefix('guide')->name('guide.')->middleware(['auth', \App\Http\Middleware\IsGuide::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.guide');
    })->name('dashboard');
});

// khach hang dat tour routes
Route::prefix('admin/khach-hang-dat-tours')
    ->name('khach-hang-dat-tours.')
    ->group(function () {
        Route::get('/', [KhachHangDatTourController::class, 'index'])->name('index');
        Route::get('/create', [KhachHangDatTourController::class, 'create'])->name('create');
        Route::post('/', [KhachHangDatTourController::class, 'store'])->name('store');
        Route::get('/{id}', [KhachHangDatTourController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [KhachHangDatTourController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KhachHangDatTourController::class, 'update'])->name('update');
        Route::delete('/{id}', [KhachHangDatTourController::class, 'destroy'])->name('destroy');
        
    });