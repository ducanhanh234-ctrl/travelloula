<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietLichTrinh extends Model
{
    protected $fillable = [

        'lich_trinh_tour_id',

        'gio_bat_dau',

        'gio_ket_thuc',

        'tieu_de',

        'noi_dung',

        'thu_tu'

    ];

    public function lichTrinh()
    {
        return $this->belongsTo(
            LichTrinhTour::class,
            'lich_trinh_tour_id'
        );
    }
}