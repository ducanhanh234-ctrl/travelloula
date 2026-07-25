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

        /*
        |--------------------------------------------------------------------------
        | Danh sách user có tài khoản
        |--------------------------------------------------------------------------
        */

        $userIds = DB::table('users')
            ->where('is_active', 1)
            ->pluck('id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Khoảng 60% booking sẽ là khách có tài khoản
        |--------------------------------------------------------------------------
        */

        $bookingCoTaiKhoan = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
        ];

        /*
        |--------------------------------------------------------------------------
        | Dữ liệu booking
        |--------------------------------------------------------------------------
        */

        $lichs = [

            1 => [
                'tour' => 1,
                'bookings' => [5, 4, 3],
            ],

            2 => [
                'tour' => 1,
                'bookings' => [5, 5, 5],
            ],

            3 => [
                'tour' => 1,
                'bookings' => [6, 6, 6],
            ],

            4 => [
                'tour' => 1,
                'bookings' => [8, 7],
            ],

            5 => [
                'tour' => 1,
                'bookings' => [10, 5],
            ],

            6 => [
                'tour' => 1,
                'bookings' => [8, 7, 5],
            ],

        ];

        foreach ($lichs as $lichId => $info) {

            foreach ($info['bookings'] as $soNguoiLon) {

                $tongTien = $soNguoiLon * 3200000;

                $laKhachCoTaiKhoan = in_array(
                    $bookingId,
                    $bookingCoTaiKhoan
                );

                $row = [

                    'tour_id' => $info['tour'],

                    'lich_khoi_hanh_id' => $lichId,

                    'khuyen_mai_id' => null,

                    'ma_dat_tour' => 'TDBK' .
                        str_pad($bookingId, 5, '0', STR_PAD_LEFT),

                    'so_nguoi_lon' => $soNguoiLon,
                    'so_tre_em' => 0,
                    'so_em_be' => 0,

                    'tong_tien' => $tongTien,
                    'so_tien_da_thanh_toan' => $tongTien,

                    'trang_thai' => 'da_thanh_toan',

                    'ghi_chu' => null,

                    'ngay_dat' => now()->subDays(rand(3, 7)),

                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                /*
                |--------------------------------------------------------------------------
                | Khách có tài khoản
                |--------------------------------------------------------------------------
                */

                if ($laKhachCoTaiKhoan) {

                    $row['nguoi_dung_id']
                        = $userIds[array_rand($userIds)];

                    $row['ten_nguoi_dat'] = null;
                    $row['so_dien_thoai'] = null;
                    $row['email'] = null;
                }

                /*
                |--------------------------------------------------------------------------
                | Khách vãng lai
                |--------------------------------------------------------------------------
                */ else {

                    $row['nguoi_dung_id'] = null;

                    $row['ten_nguoi_dat']
                        = 'Khách Hotline ' . $bookingId;

                    $row['so_dien_thoai']
                        = '091' . str_pad($bookingId, 7, '0', STR_PAD_LEFT);

                    $row['email']
                        = 'hotline' . $bookingId . '@gmail.com';
                }

                $data[] = $row;

                $bookingId++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Booking OPEN 1 (Hotline)
        |--------------------------------------------------------------------------
        */

        $data[] = [

            'nguoi_dung_id' => null,

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

        /*
        |--------------------------------------------------------------------------
        | Booking OPEN 2 (Có tài khoản)
        |--------------------------------------------------------------------------
        */

        $data[] = [

            'nguoi_dung_id' => $userIds[array_rand($userIds)],

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

            'ten_nguoi_dat' => null,
            'so_dien_thoai' => null,
            'email' => null,

            'created_at' => now(),
            'updated_at' => now(),

        ];

        DB::table('dat_tours')->insert($data);
    }
}
