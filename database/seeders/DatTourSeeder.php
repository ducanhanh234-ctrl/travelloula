<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatTourSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        $bookingId = 1;
        $userId = 2;

        /*
        |--------------------------------------------------------------------------
        | Số khách của từng booking
        |--------------------------------------------------------------------------
        | Tổng phải đúng với so_cho_da_dat trong LichKhoiHanhTourSeeder
        */

        $lichs = [

            // lịch 1 -> tổng 12 khách
            1 => [
                'tour' => 1,
                'bookings' => [5, 4, 3],
            ],

            // lịch 2 -> tổng 15 khách
            2 => [
                'tour' => 1,
                'bookings' => [5, 5, 5],
            ],

            // lịch 3 -> tổng 18 khách
            3 => [
                'tour' => 1,
                'bookings' => [6, 6, 6],
            ],

            // lịch 4 -> tổng 15 khách
            4 => [
                'tour' => 1,
                'bookings' => [8, 7],
            ],

            // lịch 5 -> tổng 15 khách
            5 => [
                'tour' => 1,
                'bookings' => [10, 5],
            ],

            // lịch 6 -> tổng 20 khách
            6 => [
                'tour' => 1,
                'bookings' => [8, 7, 5],
            ],
        ];

        foreach ($lichs as $lichId => $info) {

            foreach ($info['bookings'] as $soNguoiLon) {

                $tongTien = $soNguoiLon * 3200000;

                $data[] = [

                    'nguoi_dung_id' => $userId,

                    'tour_id' => $info['tour'],

                    'lich_khoi_hanh_id' => $lichId,

                    'khuyen_mai_id' => null,

                    'ma_dat_tour' => 'TDBK' . str_pad($bookingId, 5, '0', STR_PAD_LEFT),

                    'so_nguoi_lon' => $soNguoiLon,
                    'so_tre_em' => 0,
                    'so_em_be' => 0,

                    'tong_tien' => $tongTien,
                    'so_tien_da_thanh_toan' => $tongTien,

                    'trang_thai' => 'da_thanh_toan',

                    'ghi_chu' => null,

                    'ngay_dat' => now()->subDays(rand(3, 7)),

                    'ten_nguoi_dat' => 'Khách ' . $bookingId,
                    'so_dien_thoai' => '090000' . str_pad($bookingId, 4, '0', STR_PAD_LEFT),
                    'email' => 'khach' . $bookingId . '@gmail.com',

                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $bookingId++;

                $userId++;

                if ($userId > 7) {
                    $userId = 2;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Lịch OPEN
        |--------------------------------------------------------------------------
        */

        $data[] = [

            'nguoi_dung_id' => 2,
            'tour_id' => 1,
            'lich_khoi_hanh_id' => 7,
            'khuyen_mai_id' => null,

            'ma_dat_tour' => 'DT99991',

            'so_nguoi_lon' => 8,
            'so_tre_em' => 0,
            'so_em_be' => 0,

            'tong_tien' => 25600000,
            'so_tien_da_thanh_toan' => 25600000,

            'trang_thai' => 'da_thanh_toan',

            'ghi_chu' => null,

            'ngay_dat' => now(),

            'ten_nguoi_dat' => 'Khách Open 1',
            'so_dien_thoai' => '0911111111',
            'email' => 'open1@gmail.com',

            'created_at' => now(),
            'updated_at' => now(),
        ];

        $data[] = [

            'nguoi_dung_id' => 3,
            'tour_id' => 2,
            'lich_khoi_hanh_id' => 8,
            'khuyen_mai_id' => null,

            'ma_dat_tour' => 'DT99992',

            'so_nguoi_lon' => 10,
            'so_tre_em' => 0,
            'so_em_be' => 0,

            'tong_tien' => 52000000,
            'so_tien_da_thanh_toan' => 52000000,

            'trang_thai' => 'da_thanh_toan',

            'ghi_chu' => null,

            'ngay_dat' => now(),

            'ten_nguoi_dat' => 'Khách Open 2',
            'so_dien_thoai' => '0922222222',
            'email' => 'open2@gmail.com',

            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('dat_tours')->insert($data);
    }
}
