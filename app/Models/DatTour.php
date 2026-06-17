<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatTour extends Model
{
    protected $table = 'dat_tours';

    protected $fillable = [
        'nguoi_dung_id',
        'tour_id',

        'so_nguoi',
        'ngay_khoi_hanh',
        'trang_thai',
        'ghi_chu',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
    public function thanhToans()
    {
        return $this->hasMany(ThanhToan::class, 'dat_tour_id');
    }



    protected $casts = [
        'ngay_dat' => 'datetime',
        'tong_tien' => 'decimal:2',
        'so_tien_da_thanh_toan' => 'decimal:2',
    ];

    public function khachHangs()
    {
        return $this->hasMany(KhachHangDatTour::class, 'dat_tour_id');
    }

    

    public function lichKhoiHanh()
    {
        return $this->belongsTo(LichKhoiHanhTour::class, 'lich_khoi_hanh_id');
    }

    
}


