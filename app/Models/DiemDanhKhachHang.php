<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiemDanhKhachHang extends Model
{
    protected $fillable = [
        'khach_hang_dat_tour_id',
        'lich_khoi_hanh_id',
        'huong_dan_vien_id',
        'ngay_thu',
        'ngay_diem_danh',
        'trang_thai',
        'thoi_gian_diem_danh',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_diem_danh' => 'date',
        'thoi_gian_diem_danh' => 'datetime',
    ];

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
            LichKhoiHanhTour::class,
            'lich_khoi_hanh_id'
        );
    }

    public function huongDanVien()
    {
        return $this->belongsTo(
            HuongDanVien::class,
            'huong_dan_vien_id'
        );
    }
}
