<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhuongTien extends Model
{
    protected $table = 'phuong_tiens';

    protected $fillable = [
        'bien_so_xe',
        'loai_xe',
        'loai_phuong_tien',
        'hang_xe',
        'nam_san_xuat',
        'mau_xe',
        'so_cho',
        'trang_thai',
        'ten_tai_xe',
        'so_dien_thoai_tai_xe',
        'ghi_chu',
    ];

    protected $casts = [
        'nam_san_xuat' => 'integer',
        'so_cho' => 'integer',
        'trang_thai' => 'integer',
    ];

    public static function loaiPhuongTienList(): array
    {
        return [
            'xe_16_cho' => 'Xe 16 chỗ',
            'xe_29_cho' => 'Xe 29 chỗ',
            'xe_45_cho' => 'Xe 45 chỗ',
        ];
    }

    public function getLoaiPhuongTienTextAttribute(): string
    {
        $list = [
            'xe_16_cho' => 'Xe 16 chỗ',
            'xe_29_cho' => 'Xe 29 chỗ',
            'xe_45_cho' => 'Xe 45 chỗ',

            '16 chỗ' => 'Xe 16 chỗ',
            '29 chỗ' => 'Xe 29 chỗ',
            '45 chỗ' => 'Xe 45 chỗ',

            '16 cho' => 'Xe 16 chỗ',
            '29 cho' => 'Xe 29 chỗ',
            '45 cho' => 'Xe 45 chỗ',
        ];

        return $list[$this->loai_phuong_tien]
            ?? $this->loai_phuong_tien
            ?? 'Không xác định';
    }

    public static function trangThaiList(): array
    {
        return [
            1 => 'Hoạt động',
            2 => 'Đang chạy tour',
            3 => 'Bảo trì',
            4 => 'Đang sửa chữa',
            5 => 'Ngừng hoạt động',
        ];
    }

    public function getTrangThaiTextAttribute(): string
    {
        return self::trangThaiList()[$this->trang_thai]
            ?? 'Không xác định';
    }

    public function lichKhoiHanhs(): HasMany
    {
        return $this->hasMany(
            LichKhoiHanhTour::class,
            'phuong_tien_id'
        );
    }

    public function phanCongs(): HasMany
    {
        return $this->hasMany(
            PhanCong::class,
            'phuong_tien_id'
        );
    }
}
