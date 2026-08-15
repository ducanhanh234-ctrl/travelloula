<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThayDoiLichTrinh extends Model
{
    protected $table = 'thay_doi_lich_trinhs';

    protected $fillable = [
        'lich_khoi_hanh_id',
        'chi_tiet_lich_trinh_id',
        'huong_dan_vien_id',
        'loai_thay_doi',
        'tieu_de_moi',
        'gio_bat_dau_moi',
        'gio_ket_thuc_moi',
        'ly_do',
    ];

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
}
