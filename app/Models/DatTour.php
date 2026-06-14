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
        'khuyen_mai_id',
        'ma_dat_tour',
        'so_nguoi_lon',
        'so_tre_em',
        'so_em_be',
        'tong_tien',
        'so_tien_da_thanh_toan',
        'trang_thai',
        'ghi_chu',
        'ngay_dat',
    ];

    protected $casts = [
        'ngay_dat' => 'datetime',
        'tong_tien' => 'decimal:2',
        'so_tien_da_thanh_toan' => 'decimal:2',
    ];

    public function khachHangs()
    {
        return $this->hasMany(KhachHangDatTour::class, 'dat_tour_id');
    }

    public function tour()
    {
        return $this->belongsTo(DanhSachTour::class, 'tour_id');
    }

    public function lichKhoiHanh()
    {
        return $this->belongsTo(LichKhoiHanhTour::class, 'lich_khoi_hanh_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }
}