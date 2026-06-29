<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gia';

    protected $fillable = [
        'user_id',
        'tour_id',
        'so_sao',
        'noi_dung',
        'trang_thai',
    ];

    public function tour()
    {
        return $this->belongsTo(DanhSachTour::class, 'tour_id');
    }
}