<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhatKyTour extends Model
{
    protected $table = 'nhat_ky_tours';

    protected $fillable = [
        'tour_id',
        'nguoi_dung_id',
        'hanh_dong',
        'du_lieu_cu',
        'du_lieu_moi',
        'dia_chi_ip',
    ];

    public function tour()
    {
        return $this->belongsTo(
            DanhSachTour::class,
            'tour_id'
        );
    }

    public function nguoiDung()
    {
        return $this->belongsTo(
            User::class,
            'nguoi_dung_id'
        );
    }
}