<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BangGiaTour extends Model
{
    protected $fillable = [

        'tour_id',

        'loai_mua',

        'gia_nguoi_lon',
        'gia_tre_em',
        'gia_em_be',
    ];

    public function tour()
    {
        return $this->belongsTo(
            DanhSachTour::class,
            'tour_id'
        );
    }
}
