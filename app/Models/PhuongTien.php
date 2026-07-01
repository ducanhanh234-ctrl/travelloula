<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuongTien extends Model
{
    protected $table = 'phuong_tiens';

    protected $fillable = [
        'bien_so_xe',
        'loai_phuong_tien',
        'hang_xe',
        'nam_san_xuat',
        'mau_xe',
        'trang_thai',
        'ten_tai_xe',
        'so_dien_thoai_tai_xe',
        'ghi_chu',
    ];

    public static function trangThaiList()
    {
        return [
            1 => 'Hoạt động',
            2 => 'Đang chạy tour',
            3 => 'Bảo trì',
            4 => 'Đang sửa chữa',
            5 => 'Ngừng hoạt động',
        ];
    }

    public function lichKhoiHanhs()
    {
        return $this->hasMany(
            LichKhoiHanhTour::class,
            'phuong_tien_id'
        );
    }
}
