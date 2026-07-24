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
        'hdv_ids',
        'phuong_tien_ids',
        'ngay_phan_cong',
        'ghi_chu'

    ];

    protected $casts = [
        'hdv_ids' => 'array',
        'phuong_tien_ids' => 'array',
    ];

    public function lichKhoiHanh()
    {
        return $this->belongsTo(
            LichKhoiHanhTour::class,
            'lich_khoi_hanh_id',
            'id'
        );
    }

    public function hdv()
    {
        return $this->belongsTo(HuongDanVien::class);
    }

    public function phuongTien()
    {
        return $this->belongsTo(PhuongTien::class);
    }

    public function getHdvListAttribute()
    {
        $hdvIds = collect($this->hdv_ids ?? [$this->hdv_id])->filter()->all();
        return HuongDanVien::whereIn('id', $hdvIds)->get();
    }

    public function getPhuongTienListAttribute()
    {
        $phuongTienIds = collect($this->phuong_tien_ids ?? [$this->phuong_tien_id])->filter()->all();
        return PhuongTien::whereIn('id', $phuongTienIds)->get();
    }
}
