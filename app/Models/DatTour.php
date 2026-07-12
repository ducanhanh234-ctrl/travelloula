<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class DatTour extends Model
{



    use SoftDeletes;
    protected $table = 'dat_tours';

    protected $fillable = [
        'nguoi_dung_id',
        'ten_nguoi_dat',
        'so_dien_thoai',
        'email',
        'tour_id',
        'lich_khoi_hanh_id',
        'khuyen_mai_id',
        'ma_dat_tour',
        'so_nguoi_lon',
        'so_tre_em',
        'so_em_be',
        'tong_tien',
        'so_tien_da_thanh_toan',
        'trang_thai',
        'ghi_chu',
        'ngay_dat',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function lichKhoiHanh()
    {
        return $this->belongsTo(
            LichKhoiHanhTour::class,
            'lich_khoi_hanh_id'
        );
    }

    public function thanhToans()
    {
        return $this->hasMany(
            ThanhToan::class,

            'dat_tour_id'
        );
    }


    public function khachDaiDien()
    {
        return $this->hasOne(
            KhachHangDatTour::class,
            'dat_tour_id'
        )->orderBy('id', 'asc');
    }


    public function khachHangs()
    {
        return $this->hasMany(
            KhachHangDatTour::class,
            'dat_tour_id'
        );
    }

    protected $casts = [
        'ngay_dat' => 'datetime',
        'tong_tien' => 'decimal:2',
        'so_tien_da_thanh_toan' => 'decimal:2',
    ];

    public function getTrangThaiTextAttribute(): string
    {
        return match ($this->trang_thai) {
            'cho_xac_nhan' => 'Chờ xác nhận',
            'da_xac_nhan' => 'Đã xác nhận',
            'da_thanh_toan' => 'Đã thanh toán',
            'da_huy' => 'Đã hủy',
            'hoan_thanh' => 'Hoàn thành',
            default => 'Không xác định',
        };
    }

    public function getTrangThaiBadgeAttribute(): string
    {
        return match ($this->trang_thai) {
            'cho_xac_nhan' => 'warning',
            'da_xac_nhan' => 'info',
            'da_thanh_toan' => 'success',
            'da_huy' => 'danger',
            'hoan_thanh' => 'primary',
            default => 'secondary',
        };
    }

    public function khachHangDatTour()
    {
        return $this->hasMany(
            KhachHangDatTour::class,
            'dat_tour_id'

        );
    }

    public function getTongSoKhachAttribute(): int
    {
        return $this->so_nguoi_lon
            + $this->so_tre_em
            + $this->so_em_be;
    }

    public function getTenHienThiAttribute(): ?string
    {
        if ($this->laKhachThanhVien()) {
            return $this->nguoiDung->name;
        }

        return $this->ten_nguoi_dat;
    }

    public function getEmailHienThiAttribute(): ?string
    {
        if ($this->laKhachThanhVien()) {
            return $this->nguoiDung->email;
        }

        return $this->email;
    }

    public function getSoDienThoaiHienThiAttribute(): ?string
    {
        if ($this->laKhachThanhVien()) {
            return $this->nguoiDung->phone;
        }

        return $this->so_dien_thoai;
    }

    public function getLoaiKhachAttribute(): string
    {
        return $this->laKhachThanhVien()
            ? 'Khách có tài khoản'
            : 'Khách vãng lai';
    }

    // public function laKhachThanhVien(): bool
    // {
    //     return !is_null($this->nguoi_dung_id)
    //         && $this->relationLoaded('nguoiDung')
    //         ? !is_null($this->nguoiDung)
    //         : User::whereKey($this->nguoi_dung_id)->exists();
    // }

    public function laKhachThanhVien(): bool
    {
        return !is_null($this->nguoi_dung_id);
    }

    public function getLoaiKhachBadgeAttribute(): string
    {
        return $this->laKhachThanhVien()
            ? 'primary'
            : 'secondary';
    }

    public function getThongTinNguoiDatAttribute(): array
    {
        return [

            'ten' => $this->ten_hien_thi,

            'email' => $this->email_hien_thi,

            'phone' => $this->so_dien_thoai_hien_thi,

            'loai' => $this->loai_khach,

            'badge' => $this->loai_khach_badge,

            'ngay_dat' => optional($this->ngay_dat)
                ->format('d/m/Y H:i'),

        ];
    }
}
