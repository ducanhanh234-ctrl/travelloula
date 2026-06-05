<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/bai_viet', function(){
    return view('bai_viet.index');
});
Route::get('/{id}/bai_viet', function(){
    return view('bai_viet.detail');
})->name('bai_viet.detail');