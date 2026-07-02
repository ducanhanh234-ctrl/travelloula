<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DatTour extends Model
{

    protected $table = 'dat_tours';


    protected $fillable = [
        'nguoi_dung_id',
        'tour_id',
        'lich_khoi_hanh_id',
        'ma_dat_tour',
        'so_nguoi_lon',
        'so_tre_em',
        'tong_tien',
        'trang_thai'
    ];


    public function khachHangs()
    {
        return $this->hasMany(
            KhachHangDatTour::class,
            'dat_tour_id'
        );
    }

    public function khachDaiDien()
    {
        return $this->hasOne(
            KhachHangDatTour::class,
            'dat_tour_id'
        )->orderBy('id', 'asc');
    }

    public function lichKhoiHanh()
    {
        return $this->belongsTo(
            LichKhoiHanhTour::class,
            'lich_khoi_hanh_id'
        );
    }
}
