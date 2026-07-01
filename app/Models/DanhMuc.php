<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DanhMuc extends Model
{
    protected $table = 'danh_mucs';

    protected $fillable = [
        'ten_danh_muc',
        'mo_ta',
        'hinh_anh',

        'trang_thai'

  ];

    public function tours()
    {

        return $this->hasMany(
            DanhSachTour::class,
            'danh_muc_id'
        );
    }
}

