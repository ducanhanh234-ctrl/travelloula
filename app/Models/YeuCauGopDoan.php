<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ChiTietYeuCauGopDoan;
use App\Models\PhuongTien;
use App\Models\HuongDanVien;

class YeuCauGopDoan extends Model
{
    protected $table = 'yeu_cau_gop_doans';
    protected $casts = [
        'ly_do_de_xuat' => 'array',
    ];

    protected $fillable = [
        'ma_yeu_cau',
        'dia_diem_de_xuat',
        'ly_do_de_xuat',
        'loai_de_xuat',
        'trang_thai',
        'xe_de_xuat',
        'phuong_tien_id',
        'huong_dan_vien_id',
        'thoi_gian_hoan_tat',
    ];

    // 1 yêu cầu có nhiều chi tiết lịch
    public function chiTiets()
    {
        return $this->hasMany(ChiTietYeuCauGopDoan::class, 'yeu_cau_gop_doan_id');
    }

    // xe được gán sau khi gộp
    public function phuongTien()
    {
        return $this->belongsTo(PhuongTien::class, 'phuong_tien_id');
    }

    // hướng dẫn viên được gán sau khi gộp
    public function huongDanVien()
    {
        return $this->belongsTo(HuongDanVien::class, 'huong_dan_vien_id');
    }
}
