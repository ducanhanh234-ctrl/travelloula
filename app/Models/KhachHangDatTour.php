<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHangDatTour extends Model
{
    protected $table = 'khach_hang_dat_tours';

    protected $fillable = [
        'dat_tour_id',
        'ho_ten',
        'gioi_tinh',
        'nam_sinh',
        'so_dien_thoai',
        'email',
        'so_giay_to',
        'loai_giay_to',
        'loai_hanh_khach',
        'trang_thai_thanh_toan',
        'trang_thai_check_in',
        'thoi_gian_check_in',
        'so_tien_da_thanh_toan',
        'tong_tien',
        'yeu_cau_dac_biet',
        'so_phong',
        'loai_phong',
        'da_check_in',
        'thoi_gian_da_check_in',
        'ghi_chu',
    ];

    public function datTour()
    {
        return $this->belongsTo(DatTour::class, 'dat_tour_id');
    }
}
