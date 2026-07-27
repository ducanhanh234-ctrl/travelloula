<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HinhAnhTour extends Model
{
    protected $table = 'hinh_anh_tours';

    protected $fillable = [
        'tour_id',
        'duong_dan_anh',
        'loai_anh',
        'la_anh_dai_dien',
        'thu_tu_hien_thi',
    ];

    protected $casts = [
        'la_anh_dai_dien' => 'boolean',
        'thu_tu_hien_thi' => 'integer',
    ];

    public function tour()
    {
        return $this->belongsTo(DanhSachTour::class, 'tour_id');
    }
}