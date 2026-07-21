<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class HuongDanVien extends Model
{
    use HasFactory;

    protected $table = 'huong_dan_viens';

    protected $fillable = [
        'user_id',
        'ho_ten',
        'email',
        'so_cccd',
        'ngay_cap_cccd',
        'noi_cap_cccd',
        'anh_cccd_truoc',
        'anh_cccd_sau',
        'so_dien_thoai',
        'ngay_sinh',
        'gioi_tinh',
        'dia_chi',
        'anh_dai_dien',
        'so_nam_kinh_nghiem',
        'ngon_ngu_thanh_thao',
        'mo_ta',
        'trang_thai',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'ngay_cap_cccd' => 'date',
        'so_nam_kinh_nghiem' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phanCongs()
    {
        return $this->hasMany(PhanCong::class);
    }

    public function getTrangThaiHienThiAttribute()
    {
        return match ($this->trang_thai) {
            'hoat_dong' => [
                'text' => 'Đang hoạt động',
                'class' => 'bg-success',
            ],

            'san_sang' => [
                'text' => 'Sẵn sàng',
                'class' => 'bg-success',
            ],

            'dang_dan_tour' => [
                'text' => 'Đang dẫn tour',
                'class' => 'bg-primary',
            ],

            'khong_hoat_dong' => [
                'text' => 'Tạm nghỉ',
                'class' => 'bg-secondary',
            ],

            'bi_khoa' => [
                'text' => 'Bị khóa',
                'class' => 'bg-danger',
            ],

            'nghi_viec' => [
                'text' => 'Nghỉ việc',
                'class' => 'bg-dark',
            ],

            default => [
                'text' => 'Không xác định',
                'class' => 'bg-dark',
            ],
        };
    }

    public function checkIns()
    {
        return $this->hasMany(
            CheckInKhachHang::class,
            'huong_dan_vien_id'
        );
    }

    public function baoCaoSuCos()
    {
        return $this->hasMany(
            BaoCaoSuCo::class,
            'huong_dan_vien_id'
        );
    }

}
