<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'danh_sach_tours';

    protected $fillable = [
        'ten_tour',
        'mo_ta',
        'gia',
        'hinh_anh',
        'ngay_khoi_hanh',
        'so_cho_con_trong',
        'trang_thai',
    ];

    public function datTours()
    {
        return $this->hasMany(DatTour::class, 'tour_id');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'tour_id');
    }

}
