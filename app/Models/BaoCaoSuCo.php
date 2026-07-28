<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaoCaoSuCo extends Model
{
    use SoftDeletes;

    protected $table = 'bao_cao_su_cos';

    protected $fillable = [
        'lich_khoi_hanh_id',
        'huong_dan_vien_id',
        'admin_xu_ly_id',
        'tieu_de',
        'loai_su_co',
        'muc_do',
        'noi_dung',
        'trang_thai',
        'ghi_chu_xu_ly',
        'thoi_gian_tiep_nhan',
        'thoi_gian_xu_ly',
    ];

    protected $casts = [
        'thoi_gian_tiep_nhan' => 'datetime',
        'thoi_gian_xu_ly' => 'datetime',
    ];

    public function lichKhoiHanh(): BelongsTo
    {
        return $this->belongsTo(LichKhoiHanhTour::class, 'lich_khoi_hanh_id');
    }

    public function huongDanVien(): BelongsTo
    {
        return $this->belongsTo(HuongDanVien::class, 'huong_dan_vien_id');
    }

    public function adminXuLy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_xu_ly_id');
    }

    public static function loaiSuCoList(): array
    {
        return [
            'phuong_tien' => 'Phương tiện',
            'lich_trinh' => 'Lịch trình',
            'khach_hang' => 'Khách hàng',
            'dich_vu' => 'Dịch vụ',
            'an_ninh' => 'An ninh',
            'suc_khoe' => 'Sức khỏe',
            'khac' => 'Khác',
        ];
    }

    public static function mucDoList(): array
    {
        return [
            'thap' => 'Thấp',
            'trung_binh' => 'Trung bình',
            'cao' => 'Cao',
            'khan_cap' => 'Khẩn cấp',
        ];
    }

    public static function trangThaiList(): array
    {
        return [
            'moi' => 'Mới',
            'da_tiep_nhan' => 'Đã tiếp nhận',
            'dang_xu_ly' => 'Đang xử lý',
            'da_xu_ly' => 'Đã xử lý',
            'tu_choi' => 'Từ chối',
        ];
    }

    public function getLoaiSuCoTextAttribute(): string
    {
        return self::loaiSuCoList()[$this->loai_su_co] ?? 'Không xác định';
    }

    public function getMucDoTextAttribute(): string
    {
        return self::mucDoList()[$this->muc_do] ?? 'Không xác định';
    }

    public function getTrangThaiTextAttribute(): string
    {
        return self::trangThaiList()[$this->trang_thai] ?? 'Không xác định';
    }
}
