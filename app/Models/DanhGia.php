<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gia';

    protected $fillable = [
        'khach_hang_dat_tour_id',
        'tour_id',
        'so_sao',
        'tieu_de',
        'noi_dung_danh_gia',
        'hien_thi',
        'thoi_gian_danh_gia',
    ];

    protected $casts = [
        'so_sao' => 'integer',
        'hien_thi' => 'boolean',
        'thoi_gian_danh_gia' => 'datetime',
    ];

    public function khachHangDatTour()
    {
        return $this->belongsTo(
            KhachHangDatTour::class,
            'khach_hang_dat_tour_id'
        );
    }

    public function tour()
    {
        return $this->belongsTo(
            DanhSachTour::class,
            'tour_id'
        );
    }

    public function scopeDaDuyet(Builder $query): Builder
    {
        return $query->where('hien_thi', 1);
    }

    public function scopeChoDuyet(Builder $query): Builder
    {
        return $query->where('hien_thi', 0);
    }
}