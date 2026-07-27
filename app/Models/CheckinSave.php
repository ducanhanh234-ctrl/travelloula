<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckinSave extends Model
{
    use HasFactory;

    protected $table = 'checkin_saves';

    protected $fillable = [
        'lich_khoi_hanh_id',
        'chi_tiet_lich_trinh_id',
        'huong_dan_vien_id',
        'action',
    ];

    public function lichKhoiHanh()
    {
        return $this->belongsTo(LichKhoiHanhTour::class, 'lich_khoi_hanh_id');
    }

    public function chiTiet()
    {
        return $this->belongsTo(ChiTietLichTrinh::class, 'chi_tiet_lich_trinh_id');
    }

    public function huongDanVien()
    {
        return $this->belongsTo(HuongDanVien::class, 'huong_dan_vien_id');
    }
}
