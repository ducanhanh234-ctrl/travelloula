<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class BangGiaTour extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'ten_bang_gia',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'phan_tram_tang',
        'gia_nguoi_lon',
        'gia_tre_em',
        'trang_thai'
    ];

    public function tour()
    {
        return $this->belongsTo(DanhSachTour::class);
    }
}
