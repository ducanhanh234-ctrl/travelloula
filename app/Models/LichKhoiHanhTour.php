<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HuongDanVien;
use Carbon\Carbon;
use App\Models\ChiTietYeuCauGopDoan;
use App\Models\DanhSachTour;
use App\Models\DatTour;
use App\Models\PhuongTien;

class LichKhoiHanhTour extends Model
{
    use HasFactory;





    protected $table = 'lich_khoi_hanh_tours';

    protected $fillable = [
        'tour_id',
        'ngay_khoi_hanh',
        'ngay_ket_thuc',

        'so_cho',
        'so_cho_con_lai',
        'so_cho_da_dat',
        'huong_dan_vien_id',
        'gia_nguoi_lon',
        'gia_tre_em',
        'trang_thai',
        'dang_gop_doan',
        'gop_vao_lich_id',
        'da_gop',

        'huong_dan_vien_id',
        'phuong_tien_id',
        'trang_thai',
    ];

    protected $casts = [
        'ngay_khoi_hanh' => 'date',
        'ngay_ket_thuc' => 'date',

    ];

    public function tour()
    {

        return $this->belongsTo(DanhSachTour::class, 'tour_id');

    }

    public function huongDanVien()
    {
        return $this->belongsTo(
            HuongDanVien::class,
            'huong_dan_vien_id'
        );
    }


    public function getTrangThaiHienThiAttribute()
    {
        $today = Carbon::today();

        $ngayKhoiHanh = Carbon::parse($this->ngay_khoi_hanh);
        $ngayKetThuc = Carbon::parse($this->ngay_ket_thuc);

        $ngayDongBan = $ngayKhoiHanh->copy()->subDays(7);

        // 1. Đã hủy
        if ($this->trang_thai === 'cancelled') {
            return 'Đã hủy';
        }

        // 2. Đã kết thúc
        if ($ngayKetThuc->lt($today)) {
            return 'Đã kết thúc';
        }

        // 3. Đang diễn ra
        if (
            $ngayKhoiHanh->lte($today)
            &&
            $ngayKetThuc->gte($today)
        ) {
            return 'Đang diễn ra';
        }

        // 4. Hết chỗ
        if ($this->so_cho_con_lai <= 0) {
            return 'Hết chỗ';
        }

        // 5. Đóng bán trước 7 ngày
        if ($today->gte($ngayDongBan)) {
            return 'Đã đóng';
        }

        // 6. Mở bán
        return 'Mở bán';
    }

    public function chiTietGopDoan()
    {
        return $this->hasMany(ChiTietYeuCauGopDoan::class, 'lich_khoi_hanh_id');
    }


    public function datTours()
    {
        return $this->hasMany(
            DatTour::class,
            'lich_khoi_hanh_id'
        );
    }


    public function lichGopDen()
    {
        return $this->belongsTo(
            LichKhoiHanhTour::class,
            'gop_vao_lich_id'
);
    }
    public function phuongTien()
    {
        return $this->belongsTo(
            PhuongTien::class,
            'phuong_tien_id'

        );
    }
    public function phanCong()
    {
        return $this->hasOne(PhanCong::class);
    }
}
