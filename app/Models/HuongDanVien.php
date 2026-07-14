<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class HuongDanVien extends Model
{
    use HasFactory;

    protected $table = 'huong_dan_viens';

    protected $fillable = [
        'user_id',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'ngay_sinh',
        'gioi_tinh',
        'dia_chi',
        'anh_dai_dien',
        'so_nam_kinh_nghiem',
        'mo_ta',
        'trang_thai',
    ];

    public function getTrangThaiHienThiAttribute()
    {
        return match ($this->trang_thai) {

            'hoat_dong' => [
                'text' => 'Đang hoạt động',
                'class' => 'bg-success'
            ],

            'khong_hoat_dong' => [
                'text' => 'Tạm nghỉ',
                'class' => 'bg-secondary'
            ],

            'bi_khoa' => [
                'text' => 'Bị khóa',
                'class' => 'bg-danger'
            ],

            default => [
                'text' => 'Không xác định',
                'class' => 'bg-dark'
            ]
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'ngay_sinh' => 'date',
        'so_nam_kinh_nghiem' => 'integer',
    ];
    public function phanCongs()
    {
        return $this->hasMany(PhanCong::class);
    }
}
