<?php

use App\Http\Controllers\ThanhToanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;

Route::get('/', function () {
    return view('trang_chu.index');
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
    return view('demo');
});
Route::get('/trang_chu', function () {
    return view('trang_chu.index');
});
Route::get('/ve_chung_toi', function () {
    return view('ve_chung_toi.index');
});


Route::get('/danh_sach_tour_yeu_thich', function () {
    return view('danh_sach_tour_yeu_thich.index');
});
Route::get('/dieu_khoan', function () {
    return view('dieu_khoan.index');
});
