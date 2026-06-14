<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatTour extends Model
{
    protected $table = 'dat_tours';

    protected $fillable = [
        'nguoi_dung_id',
        'tour_id',
        'so_nguoi',
        'ngay_khoi_hanh',
        'trang_thai',
        'ghi_chu',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
    public function thanhToans()
    {
        return $this->hasMany(ThanhToan::class, 'dat_tour_id');
    }
}
