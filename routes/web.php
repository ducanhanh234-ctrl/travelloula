<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo', function () {
    return view('demo');
});
Route::get('/trang_chu', function () {
    return view('trang_chu.index');
});

