<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatTourTestSeeder extends Seeder
{
    public function run(): void
    {

        // Danh mục
        $danhMucId = DB::table('danh_mucs')->insertGetId([

            'ten_danh_muc' => 'Du lịch trong nước',

            'mo_ta' => 'Các tour du lịch trong nước',

            'created_at' => now(),

            'updated_at' => now(),

        ]);



        // Hướng dẫn viên

        $hdv = DB::table('huong_dan_viens')
    ->where('email','an@gmail.com')
    ->first();


if($hdv){

    $hdvId = $hdv->id;

}else{


    $hdvId = DB::table('huong_dan_viens')
        ->insertGetId([

            'ho_ten'=>'Nguyễn Văn An',

            'email'=>'an@gmail.com',

            'so_dien_thoai'=>'0988888888',

            'so_nam_kinh_nghiep'=>5,

            'trang_thai'=>'hoat_dong',

            'created_at'=>now(),

            'updated_at'=>now(),

        ]);

}

        // Tạo tour

        $tourId = DB::table('danh_sach_tours')->insertGetId([


            'danh_muc_id' => $danhMucId,


            'ten_tour' => 'Tour Hà Nội - Sapa 3N2Đ',


            'duong_dan' => 'tour-ha-noi-sapa-3n2d',


            'gia_tour' => 2500000,


            // thêm giá để form lấy

            'gia_nguoi_lon' => 2500000,

            'gia_tre_em' => 1800000,

            'gia_em_be' => 500000,


            'so_khach_toi_da' => 30,


            'trang_thai' => 'active',


            'created_at' => now(),

            'updated_at' => now(),

        ]);







        // Lịch trình tour 3 ngày


        DB::table('lich_trinh_tours')->insert([


            [

                'tour_id'=>$tourId,

                'ngay_thu'=>1,

                'tieu_de'=>'Ngày 1: Hà Nội - Sapa',

                'dia_diem'=>'Sapa',

                'hoat_dong'=>'Di chuyển, tham quan',

                'bua_an'=>'Trưa, tối',

                'thong_tin_khach_san'=>'Khách sạn 3 sao',

                'created_at'=>now(),

                'updated_at'=>now(),

            ],



            [

                'tour_id'=>$tourId,

                'ngay_thu'=>2,

                'tieu_de'=>'Ngày 2: Tham quan Sapa',

                'dia_diem'=>'Fansipan',

                'hoat_dong'=>'Vui chơi, tham quan',

                'bua_an'=>'Sáng, trưa, tối',

                'thong_tin_khach_san'=>'Khách sạn 3 sao',

                'created_at'=>now(),

                'updated_at'=>now(),

            ],



            [

                'tour_id'=>$tourId,

                'ngay_thu'=>3,

                'tieu_de'=>'Ngày 3: Sapa - Hà Nội',

                'dia_diem'=>'Hà Nội',

                'hoat_dong'=>'Trở về',

                'bua_an'=>'Sáng',

                'thong_tin_khach_san'=>null,

                'created_at'=>now(),

                'updated_at'=>now(),

            ],


        ]);








        // Lịch khởi hành

        $lichId = DB::table('lich_khoi_hanh_tours')->insertGetId([


            'tour_id'=>$tourId,


            'huong_dan_vien_id'=>$hdvId,


            'ngay_khoi_hanh'=>now()->addDays(10),


            // 3 ngày => kết thúc sau 2 ngày

            'ngay_ket_thuc'=>now()->addDays(12),



            'so_cho_con_lai'=>25,


            'so_cho_da_dat'=>5,


            'trang_thai'=>'available',


            'created_at'=>now(),

            'updated_at'=>now(),

        ]);






        // Booking test

        DB::table('dat_tours')->insert([


            'nguoi_dung_id'=>1,


            'tour_id'=>$tourId,


            'lich_khoi_hanh_id'=>$lichId,


            'ma_dat_tour'=>'BOOK001',


            'so_nguoi_lon'=>2,


            'so_tre_em'=>1,


            'so_em_be'=>0,


            'tong_tien'=>6800000,


            'so_tien_da_thanh_toan'=>3000000,


            'trang_thai'=>'cho_xac_nhan',


            'ngay_dat'=>now(),


            'created_at'=>now(),

            'updated_at'=>now(),

        ]);

    }
}
