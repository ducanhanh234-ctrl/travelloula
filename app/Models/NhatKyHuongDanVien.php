<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhatKyHuongDanVien extends Model
{
    protected $fillable = [

        'lich_khoi_hanh_id',

        'chi_tiet_lich_trinh_id',

        'khach_hang_dat_tour_id',

        'huong_dan_vien_id',

        'hanh_dong',

        'noi_dung'

    ];

    public function huongDanVien()
    {
        return $this->belongsTo(
            HuongDanVien::class
        );
    }

    public function khachHang()
    {
        return $this->belongsTo(
            KhachHangDatTour::class,
            'khach_hang_dat_tour_id'
        );
    }

    public function lichKhoiHanh()
    {
        return $this->belongsTo(
            LichKhoiHanhTour::class
        );
    }

    public function chiTiet()
    {
        return $this->belongsTo(
            ChiTietLichTrinh::class,
            'chi_tiet_lich_trinh_id'
        );
    }
}
