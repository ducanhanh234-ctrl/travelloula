<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;


    protected $table = 'banners';


    protected $fillable = [
        'tieu_de',
        'mo_ta',
        'hinh_anh',
        'duong_dan_lien_ket',
        'loai_banner',
        'vi_tri_hien_thi',
        'thu_tu_hien_thi',
        'trang_thai_hoat_dong',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'doi_tuong_hien_thi',
        'luot_nhap',
        'luot_xem'
    ];


    protected $casts = [
        'trang_thai_hoat_dong'=>'boolean',
        'doi_tuong_hien_thi'=>'array',
        'ngay_bat_dau'=>'datetime',
        'ngay_ket_thuc'=>'datetime',
    ];
}