<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BaoCaoSuCo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'lich_khoi_hanh_id',
        'huong_dan_vien_id',
        'tieu_de',
        'loai_su_co',
        'muc_do',
        'noi_dung',
        'trang_thai',

        'ghi_chu_xu_ly',
        'thoi_gian_xu_ly',
    ];

    protected $casts = [
        'thoi_gian_xu_ly' => 'datetime',
    ];

    public function lichKhoiHanh()
    {
        return $this->belongsTo(
            LichKhoiHanhTour::class,
            'lich_khoi_hanh_id'
        );
    }

    public function huongDanVien()
    {
        return $this->belongsTo(
            HuongDanVien::class,
            'huong_dan_vien_id'
        );
    }


}
