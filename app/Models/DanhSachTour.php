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

        'gia_nguoi_lon',
        'gia_tre_em',
        'gia_em_be',
    ];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }

    public function lichKhoiHanhTours()

    {
        return $this->hasMany(LichKhoiHanhTour::class, 'tour_id');
    }


    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');



    }

    public function lichTrinhs()
    {
        return $this->hasMany(
            LichTrinhTour::class,
            'tour_id'
        );
    }




    protected $casts = [
        'gia_tour' => 'decimal:2',
        'so_khach_toi_da' => 'integer',
    ];


    public function lichTrinhTours()
    {
        return $this->hasMany(LichTrinhTour::class, 'tour_id')
            ->orderBy('ngay_thu');
    }

    public function hinhAnhTours()
    {
        return $this->hasMany(HinhAnhTour::class, 'tour_id')
            ->orderBy('thu_tu_hien_thi');
    }

    public function datTours()
    {
        return $this->hasMany(DatTour::class, 'tour_id');
    }

    public function danhGia()
    {
        return $this->hasMany(DanhGia::class, 'tour_id');
    }


    public function yeuThichs()
    {
        return $this->hasMany(DanhSachTourYeuThich::class, 'tour_id');

    }
}
