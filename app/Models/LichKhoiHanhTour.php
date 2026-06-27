<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HuongDanVien;
use App\Models\PhuongTien;

class LichKhoiHanhTour extends Model
{
    protected $table = 'lich_khoi_hanh_tours';

    protected $fillable = [
        'tour_id',
        'ngay_khoi_hanh',
        'ngay_ket_thuc',
        'so_cho_con_lai',
        'so_cho_da_dat',
        'huong_dan_vien_id',
        'phuong_tien_id',
        'trang_thai',
    ];

    protected $casts = [
        'ngay_khoi_hanh' => 'date',
        'ngay_ket_thuc' => 'date',
    ];

    public function tour()
    {
        return $this->belongsTo(
            DanhSachTour::class,
            'tour_id'
        );
    }

    public function huongDanVien()
    {
        return $this->belongsTo(
            HuongDanVien::class,
            'huong_dan_vien_id'
        );
    }

    public function datTours()
    {
        return $this->hasMany(
            DatTour::class,
            'lich_khoi_hanh_id'
        );
    }

    public function phuongTien()
    {
        return $this->belongsTo(
            PhuongTien::class,
            'phuong_tien_id'
        );
    }
    public function phanCong()
    {
        return $this->hasOne(PhanCong::class);
    }
}
