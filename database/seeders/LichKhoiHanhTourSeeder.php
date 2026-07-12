<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LichKhoiHanhTourSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | 6 lịch Đà Nẵng - ĐÃ ĐÓNG BÁN
        | Dữ liệu cố định để khớp DatTourSeeder
        |--------------------------------------------------------------------------
        */

        $soChoDaDat = [

            1 => 12,
            2 => 15,
            3 => 18,
            4 => 15,
            5 => 15,
            6 => 20,

        ];

        for ($i = 1; $i <= 6; $i++) {

            $ngayKhoiHanh = $today->copy()->addDays($i);
            $ngayKetThuc = $ngayKhoiHanh->copy()->addDays(2);

            $daDat = $soChoDaDat[$i];

            $data[] = [

                'tour_id' => 1,

                'ngay_khoi_hanh' => $ngayKhoiHanh->format('Y-m-d'),
                'ngay_ket_thuc' => $ngayKetThuc->format('Y-m-d'),

                'so_cho' => 30,
                'so_cho_da_dat' => $daDat,
                'so_cho_con_lai' => 30 - $daDat,

                'gia_nguoi_lon' => 3200000,
                'gia_tre_em' => 2500000,

                'huong_dan_vien_id' => null,
                'phuong_tien_id' => null,

                'da_gop' => 0,
                'dang_gop_doan' => 0,
                'gop_vao_lich_id' => null,

                'trang_thai' => 'closed',

                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 2 lịch mở bán
        |--------------------------------------------------------------------------
        */

        for ($i = 8; $i <= 9; $i++) {

            $tourId = ($i == 8) ? 1 : 2;
            $soCho = ($tourId == 1) ? 30 : 40;

            $ngayKhoiHanh = $today->copy()->addDays($i + 6);
            $ngayKetThuc = $ngayKhoiHanh->copy()->addDays(2);

            $daDat = rand(5, 15);

            $data[] = [

                'tour_id' => $tourId,

                'ngay_khoi_hanh' => $ngayKhoiHanh->format('Y-m-d'),
                'ngay_ket_thuc' => $ngayKetThuc->format('Y-m-d'),

                'so_cho' => $soCho,
                'so_cho_da_dat' => $daDat,
                'so_cho_con_lai' => $soCho - $daDat,

                'gia_nguoi_lon' => $tourId == 1 ? 3200000 : 5200000,
                'gia_tre_em' => $tourId == 1 ? 2500000 : 4100000,

                'huong_dan_vien_id' => null,
                'phuong_tien_id' => null,

                'da_gop' => 0,
                'dang_gop_doan' => 0,
                'gop_vao_lich_id' => null,

                'trang_thai' => 'open',

                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 1 lịch đang diễn ra
        |--------------------------------------------------------------------------
        */

        $ngayKhoiHanh = $today->copy()->subDay();
        $ngayKetThuc = $today->copy()->addDay();

        $data[] = [

            'tour_id' => 2,

            'ngay_khoi_hanh' => $ngayKhoiHanh->format('Y-m-d'),
            'ngay_ket_thuc' => $ngayKetThuc->format('Y-m-d'),

            'so_cho' => 40,
            'so_cho_da_dat' => 40,
            'so_cho_con_lai' => 0,

            'gia_nguoi_lon' => 5200000,
            'gia_tre_em' => 4100000,

            'huong_dan_vien_id' => 1,
            'phuong_tien_id' => 1,

            'da_gop' => 0,
            'dang_gop_doan' => 0,
            'gop_vao_lich_id' => null,

            'trang_thai' => 'running',

            'created_at' => now(),
            'updated_at' => now(),
        ];

        /*
        |--------------------------------------------------------------------------
        | 1 lịch đã kết thúc
        |--------------------------------------------------------------------------
        */

        $ngayKhoiHanh = $today->copy()->subDays(7);
        $ngayKetThuc = $today->copy()->subDays(4);

        $data[] = [

            'tour_id' => 3,

            'ngay_khoi_hanh' => $ngayKhoiHanh->format('Y-m-d'),
            'ngay_ket_thuc' => $ngayKetThuc->format('Y-m-d'),

            'so_cho' => 35,
            'so_cho_da_dat' => 35,
            'so_cho_con_lai' => 0,

            'gia_nguoi_lon' => 6000000,
            'gia_tre_em' => 5000000,

            'huong_dan_vien_id' => 2,
            'phuong_tien_id' => 2,

            'da_gop' => 0,
            'dang_gop_doan' => 0,
            'gop_vao_lich_id' => null,

            'trang_thai' => 'done',

            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('lich_khoi_hanh_tours')->insert($data);
    }
}
