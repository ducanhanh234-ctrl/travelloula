<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhSachTour extends Model
{
    protected $table = 'danh_sach_tours';

    public function lichKhoiHanhs()
    {
        return $this->hasMany(LichKhoiHanhTour::class, 'tour_id');
    }
}
