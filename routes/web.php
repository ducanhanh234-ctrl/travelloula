<?php

use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\TourClientController;
use App\Http\Controllers\Client\TourYeuThichController;
use App\Http\Controllers\ThanhToanController;

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('/thanh_toans')->name('thanh_toans.')->group(function () {
        Route::get('/', [ThanhToanController::class, 'index'])->name('index');
        Route::get('/{id}', [ThanhToanController::class, 'show'])->name('show');
        Route::get('/{id}/edit_status', [ThanhToanController::class, 'editStatus'])->name('edit_status');
        Route::put('/{id}', [ThanhToanController::class, 'updateStatus'])->name('update_status');
        Route::delete('/{id}', [ThanhToanController::class, 'destroy'])->name('destroy');
    });
});
Route::get('/bai_viet', function () {
    return view('bai_viet.index');
});

Route::get('/{id}/bai_viet', function () {
    return view('bai_viet.detail');
})->name('bai_viet.detail');


//Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
//Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');




Route::get('/demo', function () {
    return view('Client.demo');
});



// Client routes
Route::get('/', [HomeClientController::class, 'index'])
    ->name('Client.home');

Route::get('/trang_chu', [HomeClientController::class, 'index'])
    ->name('Client.trang_chu.index');

Route::get('/tour', [TourClientController::class, 'index'])
    ->name('Client.danh_sach_tour.index');

Route::get('/tour/{id}', [TourClientController::class, 'show'])
    ->name('Client.danh_sach_tour.show');

Route::get('/bai_viet', function () {
    return view('Client.bai_viet.index');
})->name('Client.bai_viet.index');

Route::get('/bai_viet/{id}', function ($id) {
    return view('Client.bai_viet.detail');
})->name('Client.bai_viet.detail');

Route::get('/dieu_khoan', function () {
    return view('Client.dieu_khoan.index');
})->name('Client.dieu_khoan.index');

Route::get('/tour_yeu_thich', [TourYeuThichController::class, 'index'])
        ->name('Client.tour_yeu_thich.index');

    Route::post('/tour_yeu_thich/{tourId}', [TourYeuThichController::class, 'store'])
        ->name('Client.tour_yeu_thich.store');

    Route::delete('/tour_yeu_thich/{tourId}', [TourYeuThichController::class, 'destroy'])
        ->name('Client.tour_yeu_thich.destroy');

Route::get('/ve_chung_toi', function () {
    return view('Client.ve_chung_toi.index');
})->name('Client.ve_chung_toi.index');





// Auth routes
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhuongTienController;

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
    Route::resource('phuong-tiens', PhuongTienController::class);
});


// Login Guide
Route::prefix('Guide')->name('Guide.')->middleware(['auth', \App\Http\Middleware\IsGuide::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.guide');
    })->name('dashboard');
//Guide routes
});


