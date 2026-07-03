<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanCong extends Model
{
    protected $table = "phan_congs";
    protected $fillable = [

        'lich_khoi_hanh_id',
        'hdv_id',
        'phuong_tien_id',
        'ngay_phan_cong',
        'ghi_chu'

    ];
    public function lichKhoiHanh()
    {
        return $this->belongsTo(LichKhoiHanhTour::class);
    }

    public function hdv()
    {
        return $this->belongsTo(HuongDanVien::class);
    }

    public function phuongTien()
    {
        return $this->belongsTo(PhuongTien::class);
    }
}
