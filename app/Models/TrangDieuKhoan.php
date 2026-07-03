<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrangDieuKhoan extends Model
{
    protected $table = 'trang_dieu_khoans';

    protected $fillable = [
        'tieu_de',
        'duong_dan',
        'noi_dung',
        'trang_thai',
    ];
}
