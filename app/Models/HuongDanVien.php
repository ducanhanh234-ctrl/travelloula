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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'ngay_sinh' => 'date',
        'ngay_cap_cccd' => 'date',
        'so_nam_kinh_nghiem' => 'integer',
    ];
}
