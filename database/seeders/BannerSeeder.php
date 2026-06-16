<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;


class BannerSeeder extends Seeder
{

    public function run(): void
    {


        Banner::create([

            'tieu_de'=>'Khuyến mãi du lịch hè 2026',

            'mo_ta'=>'Giảm giá tour trong mùa hè',

            'hinh_anh'=>'banner-he.jpg',

            'duong_dan_lien_ket'=>'/tour',

            'loai_banner'=>'promotion',

            'vi_tri_hien_thi'=>'top',

            'thu_tu_hien_thi'=>1,

            'trang_thai_hoat_dong'=>true,

            'ngay_bat_dau'=>now(),

            'ngay_ket_thuc'=>now()->addMonth(),

            'doi_tuong_hien_thi'=>[
                'home',
                'tour'
            ],

            'luot_nhap'=>100,

            'luot_xem'=>1000

        ]);



        Banner::create([

            'tieu_de'=>'Tour nước ngoài hấp dẫn',

            'mo_ta'=>'Khám phá thế giới cùng Tour365',

            'hinh_anh'=>'banner-nuoc-ngoai.jpg',

            'duong_dan_lien_ket'=>'/category',

            'loai_banner'=>'category',

            'vi_tri_hien_thi'=>'middle',

            'thu_tu_hien_thi'=>2,

            'trang_thai_hoat_dong'=>true,

            'luot_nhap'=>50,

            'luot_xem'=>500

        ]);

    }
}