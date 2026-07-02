<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuongTien extends Model
{
    protected $table = 'phuong_tiens';

    protected $fillable = [
        'ten_phuong_tien',
        'so_cho',
        'bien_so',
        'trang_thai',
    ];
}
