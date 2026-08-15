<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuCauHoTroHdv extends Model
{
    protected $table = 'yeu_cau_ho_tro_hdvs';

    protected $fillable = [
        'lich_khoi_hanh_id',
        'huong_dan_vien_id',
        'loai_yeu_cau',
        'tieu_de',
        'ly_do',
        'trang_thai',
        'huong_dan_vien_thay_the_id',
        'admin_xu_ly_id',
        'phan_hoi_admin',
        'thoi_gian_xu_ly',
    ];

    protected $casts = [
        'thoi_gian_xu_ly' => 'datetime',
    ];

    public function lichKhoiHanh()
    {
        return $this->belongsTo(LichKhoiHanhTour::class, 'lich_khoi_hanh_id');
    }

    public function huongDanVien()
    {
        return $this->belongsTo(HuongDanVien::class, 'huong_dan_vien_id');
    }

    public function huongDanVienThayThe()
    {
        return $this->belongsTo(HuongDanVien::class, 'huong_dan_vien_thay_the_id');
    }
}
