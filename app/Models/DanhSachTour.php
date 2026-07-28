<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DanhSachTour extends Model
{
    protected $table = 'danh_sach_tours';

    protected $fillable = [
        'danh_muc_id',
        'ten_tour',
        'duong_dan',
        'anh_dai_dien',
        'gia_tour',
        'thoi_luong',
        'dia_diem_khoi_hanh',
        'diem_den',
        'so_khach_toi_da',
        'phuong_tien',
        'tieu_chuan_khach_san',
        'mo_ta',
        'tong_quan_lich_trinh',
        'dich_vu_bao_gom',
        'dich_vu_khong_bao_gom',
        'trang_thai',
        'gia_nguoi_lon',
        'gia_tre_em',
        'gia_em_be',
    ];

    protected $casts = [
        'gia_tour' => 'decimal:2',
        'gia_nguoi_lon' => 'decimal:2',
        'gia_tre_em' => 'decimal:2',
        'gia_em_be' => 'decimal:2',
        'so_khach_toi_da' => 'integer',
    ];

    public function danhMuc(): BelongsTo
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }

    /**
     * Quan hệ chuẩn được TourClientController sử dụng.
     */
    public function bangGiaTours(): HasMany
    {
        return $this->hasMany(BangGiaTour::class, 'tour_id')
            ->orderBy('ngay_bat_dau')
            ->orderBy('id');
    }

    /**
     * Giữ lại tên cũ để các phần code khác không bị lỗi.
     */
    public function bangGia(): HasMany
    {
        return $this->bangGiaTours();
    }

    /**
     * Giữ lại tên cũ để các phần code khác không bị lỗi.
     */
    public function bangGias(): HasMany
    {
        return $this->bangGiaTours();
    }

    public function lichKhoiHanh(): HasMany
    {
        return $this->hasMany(LichKhoiHanhTour::class, 'tour_id');
    }

    public function lichKhoiHanhTours(): HasMany
    {
        return $this->hasMany(LichKhoiHanhTour::class, 'tour_id');
    }

    public function lichTrinhs(): HasMany
    {
        return $this->hasMany(LichTrinhTour::class, 'tour_id');
    }

    public function lichTrinhTours(): HasMany
    {
        return $this->hasMany(LichTrinhTour::class, 'tour_id')
            ->orderBy('ngay_thu')
            ->orderBy('id');
    }

    public function lichTrinh(): HasMany
    {
        return $this->hasMany(LichTrinhTour::class, 'tour_id')
            ->orderBy('ngay_thu')
            ->orderBy('id');
    }

    public function hinhAnhTours(): HasMany
    {
        return $this->hasMany(HinhAnhTour::class, 'tour_id')
            ->orderBy('thu_tu_hien_thi')
            ->orderBy('id');
    }

    public function hinhAnhs(): HasMany
    {
        return $this->hasMany(HinhAnhTour::class, 'tour_id');
    }

    public function datTours(): HasMany
    {
        return $this->hasMany(DatTour::class, 'tour_id');
    }

    public function danhGia(): HasMany
    {
        return $this->hasMany(DanhGia::class, 'tour_id');
    }

    public function yeuThichs(): HasMany
    {
        return $this->hasMany(DanhSachTourYeuThich::class, 'tour_id');
    }
}