<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toans';

    protected $fillable = [
        'dat_tour_id',
        'nguoi_dung_id',
        'phuong_thuc_thanh_toan',
        'hoa_don_pdf',
        'so_tien',
        'ma_giao_dich',
        'trang_thai',
        'ghi_chu',
        'thoi_gian_thanh_toan',
    ];

    protected $casts = [
        'thoi_gian_thanh_toan' => 'datetime',
        'so_tien' => 'decimal:2',
    ];
    public function datTour()
    {
        return $this->belongsTo(DatTour::class, 'dat_tour_id');
    }
    public function nguoiDung()
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }
}
