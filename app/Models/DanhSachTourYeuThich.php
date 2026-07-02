<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhSachTourYeuThich extends Model
{
    protected $table = 'danh_sach_tours_yeu_thich';

    protected $fillable = [
        'nguoi_dung_id',
        'tour_id',
    ];

    public function tour()
    {
        return $this->belongsTo(DanhSachTour::class, 'tour_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }
}