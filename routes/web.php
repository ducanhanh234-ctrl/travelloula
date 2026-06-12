<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('trang_chu.index');
});


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

