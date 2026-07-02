<?php

namespace App\Models;

use App\Models\LichTrinhTour;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'danh_sach_tours';

    protected $fillable = [
        'danh_muc_id',
        'ten_tour',
        'duong_dan',
        'anh_dai_dien',
        'gia_tour',
        'gia_nguoi_lon',
        'gia_tre_em',
        'gia_em_be',
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

    public function datTours()
    {
        return $this->hasMany(DatTour::class, 'tour_id');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'tour_id');
    }

    public function danhMuc()
    {
        return $this->belongsTo(
            DanhMuc::class,
            'danh_muc_id'
        );
    }

    public function lichTrinh()
    {
        return $this->hasMany(
            LichTrinhTour::class,
            'tour_id'
        );
    }
}
