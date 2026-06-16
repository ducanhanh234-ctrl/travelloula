<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\DanhMuc;



class DanhMucSeeder extends Seeder
{


    public function run(): void
    {


        DanhMuc::create([

            'ten_danh_muc'=>'Tour trong nước',

            'mo_ta'=>'Các tour du lịch Việt Nam',

            'hinh_anh'=>'trong-nuoc.jpg',

            'trang_thai'=>'active'


        ]);



        DanhMuc::create([

            'ten_danh_muc'=>'Tour nước ngoài',

            'mo_ta'=>'Các tour quốc tế',

            'hinh_anh'=>'nuoc-ngoai.jpg',

            'trang_thai'=>'active'


        ]);



        DanhMuc::create([

            'ten_danh_muc'=>'Tour nghỉ dưỡng',

            'mo_ta'=>'Tour resort cao cấp',

            'hinh_anh'=>'nghi-duong.jpg',

            'trang_thai'=>'active'


        ]);


    }


}