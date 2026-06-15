<?php


use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\ThongKeController;

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




//Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
//Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');





Route::get('/bai_viet', function () {
    return view('Client.bai_viet.index');
});
Route::get('/{id}/bai_viet', function () {
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

Route::prefix('Admin')->name('Admin.')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.admin');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    // Route::resource('vai-tros', VaiTroController::class);
    // Route::resource('quyen-hans', QuyenHanController::class);
    Route::resource('khach-hang', KhachHangDatTourController::class);
    Route::resource('huong-dan-viens', HuongDanVienController::class);
    Route::prefix('/thanh_toans')->name('thanh_toans.')->group(function () {
        Route::get('/', [ThanhToanController::class, 'index'])->name('index');
        Route::get('/{id}', [ThanhToanController::class, 'show'])->name('show');
        Route::get('/{id}/edit_status', [ThanhToanController::class, 'editStatus'])->name('edit_status');
        Route::put('/{id}', [ThanhToanController::class, 'updateStatus'])->name('update_status');
        Route::delete('/{id}', [ThanhToanController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/danh_gias')->name('danh_gias.')->group(function () {
        Route::get('/', [DanhGiaController::class, 'index'])->name('index');
        Route::get('/{id}', [DanhGiaController::class, 'show'])->name('show');
        Route::delete('/{id}', [DanhGiaController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/thong_ke')->name('thong_ke.')->group(function () {
        Route::get('/', [ThongKeController::class, 'index'])->name('index');
        Route::get('/export', [ThongKeController::class, 'export'])->name('export');
    });
});


Route::prefix('guide')->name('guide.')->middleware(['auth', \App\Http\Middleware\IsGuide::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.guide');
    })->name('dashboard');
});
