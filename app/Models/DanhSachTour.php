<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhSachTour extends Model
{
    protected $table = 'danh_sach_tours';

    protected $fillable = [
        'danh_muc_id',
        'ten_tour',
        'duong_dan',
        'anh_dai_dien',
        'gia_tour',
        'thoi_luong',
        'dia_diem_khoi_hanh',
        'diem_den',
        'so_khach_toi_da',
        'phuong_tien',
        'tieu_chuan_khach_san',
        'mo_ta',
        'tong_quan_lich_trinh',
        'dich_vu_bao_gom',
        'dich_vu_khong_bao_gom',
        'trang_thai',
    ];

    public function lichKhoiHanh()
    {
        return $this->hasMany(LichKhoiHanhTour::class, 'tour_id');
    }

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }
}
