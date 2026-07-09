<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $table = 'bai_viets';

    protected $fillable = [
        'tieu_de',
        'duong_dan',
        'anh_dai_dien',
        'mo_ta_ngan',
        'noi_dung',
        'tac_gia',
        'luot_xem',
        'trang_thai',
    ];

    protected $casts = [
        'trang_thai' => 'integer',
        'luot_xem' => 'integer',
    ];
}