<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckInKhachHang extends Model
{
    protected $table = 'check_in_khach_hangs';

    protected $fillable = [
        'khach_hang_dat_tour_id',
        'lich_khoi_hanh_id',
        'chi_tiet_lich_trinh_id',
        'huong_dan_vien_id',
        'checkin_context',

        'thoi_gian_check_in',
        'thoi_gian_check_out',

        'trang_thai',
        'ghi_chu',

        'is_checkin_bu',
        'ly_do_checkin_bu',
        'thoi_gian_ghi_nhan_bu',

        'is_checkout_bu',
        'ly_do_checkout_bu',
        'thoi_gian_ghi_nhan_checkout_bu',
    ];

    protected $casts = [
        'is_checkin_bu' => 'boolean',
        'is_checkout_bu' => 'boolean',

        'thoi_gian_check_in' => 'datetime',
        'thoi_gian_check_out' => 'datetime',

        'thoi_gian_ghi_nhan_bu' => 'datetime',
        'thoi_gian_ghi_nhan_checkout_bu' => 'datetime',
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

    public function chiTietLichTrinh()
    {
        return $this->belongsTo(
            ChiTietLichTrinh::class,
            'chi_tiet_lich_trinh_id'
        );
    }

    public function huongDanVien()
    {
        return $this->belongsTo(
            HuongDanVien::class,
            'huong_dan_vien_id'
        );
    }

    public function checkIns()
    {
        return $this->hasMany(
            CheckInKhachHang::class,
            'khach_hang_dat_tour_id'
        );
    }
}
