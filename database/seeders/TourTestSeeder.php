<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TourTestSeeder extends Seeder
{
    public function run(): void
    {


        // ======================
        // TẠO TOUR
        // ======================

        $tourData = [

            ['Tour Hà Nội - Sapa 3N2Đ', 2500000],
            ['Tour Hà Nội - Hạ Long 2N1Đ', 1800000],
            ['Tour Đà Nẵng - Hội An 4N3Đ', 4500000],
            ['Tour Nha Trang 3N2Đ', 3900000],
            ['Tour Phú Quốc 4N3Đ', 6500000],
            ['Tour Đà Lạt 3N2Đ', 3200000],
            ['Tour Huế - Đà Nẵng 4N3Đ', 4300000],
            ['Tour Mộc Châu 2N1Đ', 1700000],
            ['Tour Hà Giang 4N3Đ', 5200000],
            ['Tour Côn Đảo 3N2Đ', 5800000],

        ];



        foreach ($tourData as $item) {


            DB::table('danh_sach_tours')
                ->updateOrInsert(

                    [
                        'duong_dan' => Str::slug($item[0])
                    ],


                    [

                        'danh_muc_id' => 1,

                        'ten_tour' => $item[0],

                        'gia_tour' => $item[1],


                        'gia_nguoi_lon' => $item[1],


                        'gia_tre_em' => round($item[1] * 0.75),


                        'gia_em_be' => round($item[1] * 0.25),


                        'so_khach_toi_da' => 30,


                        'trang_thai' => 'active',


                        'created_at' => now(),

                        'updated_at' => now(),

                    ]

                );
        }






        // ======================
        // TẠO HDV
        // ======================


        for ($i = 1; $i <= 5; $i++) {


            DB::table('huong_dan_viens')
                ->updateOrInsert(

                    [
                        'email' => "hdv$i@gmail.com"
                    ],

                    [

                        'ho_ten' => "Hướng dẫn viên $i",

                        'so_dien_thoai' => "098000000$i",

                        'so_nam_kinh_nghiep' => rand(1, 10),

                        'trang_thai' => 'hoat_dong',

                        'created_at' => now(),

                        'updated_at' => now(),

                    ]

                );
        }






        // ======================
        // TẠO XE
        // ======================


        for ($i = 1; $i <= 5; $i++) {


            DB::table('phuong_tiens')
                ->updateOrInsert(

                    [

                        'bien_so_xe' => "30A-000$i"

                    ],

                    [

                        'loai_phuong_tien' => 'Xe du lịch',

                        'hang_xe' => 'Hyundai',

                        'nam_san_xuat' => 2022,

                        'mau_xe' => 'Trắng',

                        'trang_thai' => 1,

                        'ten_tai_xe' => "Tài xế $i",

                        'so_dien_thoai_tai_xe' => "098111111$i",

                        'created_at' => now(),

                        'updated_at' => now(),

                    ]

                );
        }







        // ======================
        // LẤY ID
        // ======================


        $hdvIds = DB::table('huong_dan_viens')
            ->pluck('id')
            ->toArray();



        $xeIds = DB::table('phuong_tiens')
            ->pluck('id')
            ->toArray();




        $tours = DB::table('danh_sach_tours')->get();







        // ======================
        // TẠO LỊCH TRÌNH TOUR
        // ======================


        foreach ($tours as $tour) {



            preg_match(
                '/(\d+)N/',
                $tour->ten_tour,
                $match
            );


            $soNgay = isset($match[1])
                ? intval($match[1])
                : 1;



            // kiểm tra số ngày hiện có

            $soNgayDaCo = DB::table('lich_trinh_tours')
                ->where('tour_id', $tour->id)
                ->count();



            // nếu thiếu thì tạo thêm

            for ($i = $soNgayDaCo + 1; $i <= $soNgay; $i++) {



                DB::table('lich_trinh_tours')
                    ->insert([


                        'tour_id' => $tour->id,


                        'ngay_thu' => $i,


                        'tieu_de' => "Ngày $i: Tham quan",


                        'dia_diem' => $tour->ten_tour,


                        'hoat_dong' => "Lịch trình ngày $i",


                        'bua_an' => "Sáng, trưa, tối",


                        'thong_tin_khach_san' => "Khách sạn 3 sao",


                        'created_at' => now(),


                        'updated_at' => now(),


                    ]);
            }
        }








        // ======================
        // LỊCH KHỞI HÀNH
        // ======================



        foreach ($tours as $tour) {



            $soNgay = DB::table('lich_trinh_tours')
                ->where('tour_id', $tour->id)
                ->count();



            $ngayDi = now()->addDays(rand(5, 30));



            $lichId = DB::table('lich_khoi_hanh_tours')
                ->insertGetId([


                    'tour_id' => $tour->id,


                    'ngay_khoi_hanh' => $ngayDi,


                    'ngay_ket_thuc' =>
                    $ngayDi->copy()
                        ->addDays($soNgay - 1),



                    'so_cho_con_lai' => 30,


                    'so_cho_da_dat' => 0,


                    'huong_dan_vien_id' =>
                    $hdvIds[array_rand($hdvIds)],



                    'phuong_tien_id' =>
                    $xeIds[array_rand($xeIds)],



                    'trang_thai' => 'available',



                    'created_at' => now(),


                    'updated_at' => now(),


                ]);





            // booking test


            DB::table('dat_tours')
                ->insert([


                    'nguoi_dung_id' => 1,


                    'tour_id' => $tour->id,


                    'lich_khoi_hanh_id' => $lichId,


                    'ma_dat_tour' => "BK" . rand(10000, 99999),


                    'so_nguoi_lon' => 2,


                    'so_tre_em' => 1,


                    'so_em_be' => 0,


                    'tong_tien' => $tour->gia_tour * 2,


                    'so_tien_da_thanh_toan' => 1000000,


                    'trang_thai' => 'cho_xac_nhan',


                    'ngay_dat' => now(),


                    'created_at' => now(),


                    'updated_at' => now(),


                ]);
        }
    }
}
