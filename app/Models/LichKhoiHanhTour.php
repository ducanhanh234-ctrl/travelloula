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

        'gia_nguoi_lon',
        'gia_tre_em',

        'trang_thai',

        'dang_gop_doan',
        'gop_vao_lich_id',
        'da_gop',

        'huong_dan_vien_id',
        'phuong_tien_id',

        'da_checkin_khoi_hanh',
    ];

    protected $casts = [
        'ngay_khoi_hanh' => 'date',
        'ngay_ket_thuc' => 'date',
    ];

    public function tour()
    {
        return $this->belongsTo(
            DanhSachTour::class,
            'tour_id'
        );
    }

    public function huongDanVien()
    {
        return $this->belongsTo(
            HuongDanVien::class,
            'huong_dan_vien_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Trạng thái hiển thị
    |--------------------------------------------------------------------------
    |
    | Luồng:
    |
    | available  -> Mở bán
    | full       -> Hết chỗ
    | closed     -> Đã đóng
    | finalized  -> Đã chốt
    | assigned   -> Đã phân công
    | running    -> Đang diễn ra
    | ended      -> Đã kết thúc
    | cancelled  -> Đã hủy
    |
    */
    public function getTrangThaiHienThiAttribute()
    {
        $today = Carbon::today();

        $ngayKhoiHanh = Carbon::parse(
            $this->ngay_khoi_hanh
        )->startOfDay();

        $ngayKetThuc = Carbon::parse(
            $this->ngay_ket_thuc
        )->endOfDay();

        $ngayDongBan = $ngayKhoiHanh
            ->copy()
            ->subDays(7);

        // 1. Đã hủy
        if ($this->trang_thai === 'cancelled') {
            return 'Đã hủy';
        }

        // 2. Đã kết thúc
        if (
            $this->trang_thai === 'ended'
            || $ngayKetThuc->lt($today)
        ) {
            return 'Đã kết thúc';
        }

        // 3. Đang diễn ra
        if (
            $this->trang_thai === 'running'
            || (
                $ngayKhoiHanh->lte($today)
                && $ngayKetThuc->gte($today)
            )
        ) {
            return 'Đang diễn ra';
        }

        // 4. Đã phân công
        if ($this->trang_thai === 'assigned') {
            return 'Đã phân công';
        }

        // 5. Đã chốt
        if ($this->trang_thai === 'finalized') {
            return 'Đã chốt';
        }

        // 6. Hết chỗ
        if (
            $this->trang_thai === 'full'
            || $this->so_cho_con_lai <= 0
        ) {
            return 'Hết chỗ';
        }

        // 7. Đã đóng bán
        if (
            $this->trang_thai === 'closed'
            || $today->gte($ngayDongBan)
        ) {
            return 'Đã đóng';
        }

        // 8. Mở bán
        return 'Mở bán';
    }

    /*
    |--------------------------------------------------------------------------
    | Có thể chốt lịch?
    |--------------------------------------------------------------------------
    */
    public function coTheChot(): bool
    {
        return in_array(
            $this->trang_thai_hien_thi,
            [
                'Đã đóng',
                'Đã gộp',
                'Hết chỗ',
            ],
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Đã chốt?
    |--------------------------------------------------------------------------
    */
    public function daDuocChot(): bool
    {
        return in_array(
            $this->trang_thai,
            [
                'finalized',
                'assigned',
            ],
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Tự động cập nhật trạng thái theo thời gian
    |--------------------------------------------------------------------------
    |
    | Quan trọng:
    | - finalized và assigned phải được giữ nguyên trước ngày khởi hành.
    | - Đến ngày khởi hành thì chuyển running.
    | - Qua ngày kết thúc thì chuyển ended.
    |
    */
    public function capNhatTrangThai()
    {
        // Đã hủy thì giữ nguyên.
        if ($this->trang_thai === 'cancelled') {
            return;
        }

        $today = Carbon::today();

        $ngayKhoiHanh = Carbon::parse(
            $this->ngay_khoi_hanh
        )->startOfDay();

        $ngayKetThuc = Carbon::parse(
            $this->ngay_ket_thuc
        )->endOfDay();

        $ngayDongBan = $ngayKhoiHanh
            ->copy()
            ->subDays(7);

        /*
        |--------------------------------------------------------------------------
        | 1. Đã kết thúc
        |--------------------------------------------------------------------------
        */
        if ($ngayKetThuc->lt($today)) {
            if ($this->trang_thai !== 'ended') {
                $this->trang_thai = 'ended';
                $this->save();
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Đang diễn ra
        |--------------------------------------------------------------------------
        */
        if (
            $ngayKhoiHanh->lte($today)
            && $ngayKetThuc->gte($today)
        ) {
            if ($this->trang_thai !== 'running') {
                $this->trang_thai = 'running';
                $this->save();
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Chưa khởi hành: giữ nguyên Đã chốt / Đã phân công
        |--------------------------------------------------------------------------
        */
        if (
            in_array(
                $this->trang_thai,
                [
                    'finalized',
                    'assigned',
                ],
                true
            )
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Hết chỗ
        |--------------------------------------------------------------------------
        */
        if ($this->so_cho_con_lai <= 0) {
            if ($this->trang_thai !== 'full') {
                $this->trang_thai = 'full';
                $this->save();
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Đã đóng bán trước 7 ngày
        |--------------------------------------------------------------------------
        */
        if ($today->gte($ngayDongBan)) {
            if ($this->trang_thai !== 'closed') {
                $this->trang_thai = 'closed';
                $this->save();
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Mở bán
        |--------------------------------------------------------------------------
        */
        if ($this->trang_thai !== 'available') {
            $this->trang_thai = 'available';
            $this->save();
        }
    }

    public function chiTietGopDoan()
    {
        return $this->hasMany(
            ChiTietYeuCauGopDoan::class,
            'lich_khoi_hanh_id'
        );
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
        return $this->hasOne(
            PhanCong::class,
            'lich_khoi_hanh_id',
            'id'
        );
    }
}