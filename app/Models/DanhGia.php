<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gia';

    protected $fillable = [

        'user_id',
        'tour_id',
        'so_sao',
        'noi_dung',
        'trang_thai',

        'khach_hang_dat_tour_id',
        
        'noi_dung_danh_gia',
        'thoi_gian_danh_gia',
    ];

    public function khachHangDatTour()
    {
        return $this->belongsTo(KhachHangDatTour::class, 'khach_hang_dat_tour_id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}

