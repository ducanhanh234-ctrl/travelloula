<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/danh_sach_tour_yeu_thich', function () {
    return view('danh_sach_tour_yeu_thich.index');
});
Route::get('/dieu_khoan', function () {
    return view('dieu_khoan.index');
});
