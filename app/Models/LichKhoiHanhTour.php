<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichKhoiHanhTour extends Model
{
    public function huongDanVien()
    {
        return $this->belongsTo(
            User::class,
            'huong_dan_vien_id'
        );
    }

    protected $table = 'lich_khoi_hanh_tours';

    public function tour()
    {
        return $this->belongsTo(DanhSachTour::class, 'tour_id');
    }
}
