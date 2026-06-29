<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichTrinhTour extends Model
{
    protected $table = 'lich_trinh_tours';

    protected $fillable = [
        'tour_id',
        'ngay_thu',
        'tieu_de',
        'dia_diem',
        'hoat_dong',
        'bua_an',
        'thong_tin_khach_san',
    ];

    public function tour()
    {
        return $this->belongsTo(DanhSachTour::class, 'tour_id');
    }
}