<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    protected $table = 'khuyen_mais';

    protected $fillable = [
        'ma_khuyen_mai',
        'ten_khuyen_mai',
        'loai_giam_gia',
        'gia_tri_giam',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
    ];
}