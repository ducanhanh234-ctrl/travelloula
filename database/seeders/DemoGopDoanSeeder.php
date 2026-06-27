<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoGopDoanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lich_khoi_hanh_tours')->insert([

            /*
            ======================
            TOUR ĐÀ NẴNG
            ======================
            */

            [
                'tour_id' => 1,
                'huong_dan_vien_id' => 1,
                'ngay_khoi_hanh' => '2026-08-01',
                'ngay_ket_thuc' => '2026-08-03',
                'so_cho' => 30,
                'so_cho_da_dat' => 3,
                'so_cho_con_lai' => 27,
                'gia_nguoi_lon' => 3200000,
                'gia_tre_em' => 2500000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 1,
                'huong_dan_vien_id' => 2,
                'ngay_khoi_hanh' => '2026-08-03',
                'ngay_ket_thuc' => '2026-08-05',
                'so_cho' => 30,
                'so_cho_da_dat' => 5,
                'so_cho_con_lai' => 25,
                'gia_nguoi_lon' => 3200000,
                'gia_tre_em' => 2500000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 1,
                'huong_dan_vien_id' => 1,
                'ngay_khoi_hanh' => '2026-08-06',
                'ngay_ket_thuc' => '2026-08-08',
                'so_cho' => 30,
                'so_cho_da_dat' => 8,
                'so_cho_con_lai' => 22,
                'gia_nguoi_lon' => 3200000,
                'gia_tre_em' => 2500000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 1,
                'huong_dan_vien_id' => 2,
                'ngay_khoi_hanh' => '2026-08-09',
                'ngay_ket_thuc' => '2026-08-11',
                'so_cho' => 30,
                'so_cho_da_dat' => 12,
                'so_cho_con_lai' => 18,
                'gia_nguoi_lon' => 3200000,
                'gia_tre_em' => 2500000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 1,
                'huong_dan_vien_id' => null,
                'ngay_khoi_hanh' => '2026-08-12',
                'ngay_ket_thuc' => '2026-08-14',
                'so_cho' => 30,
                'so_cho_da_dat' => 28,
                'so_cho_con_lai' => 2,
                'gia_nguoi_lon' => 3200000,
                'gia_tre_em' => 2500000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            ======================
            TOUR PHÚ QUỐC
            ======================
            */

            [
                'tour_id' => 2,
                'huong_dan_vien_id' => 2,
                'ngay_khoi_hanh' => '2026-08-02',
                'ngay_ket_thuc' => '2026-08-05',
                'so_cho' => 40,
                'so_cho_da_dat' => 4,
                'so_cho_con_lai' => 36,
                'gia_nguoi_lon' => 5200000,
                'gia_tre_em' => 4100000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 2,
                'huong_dan_vien_id' => 1,
                'ngay_khoi_hanh' => '2026-08-06',
                'ngay_ket_thuc' => '2026-08-09',
                'so_cho' => 40,
                'so_cho_da_dat' => 10,
                'so_cho_con_lai' => 30,
                'gia_nguoi_lon' => 5200000,
                'gia_tre_em' => 4100000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 2,
                'huong_dan_vien_id' => 2,
                'ngay_khoi_hanh' => '2026-08-10',
                'ngay_ket_thuc' => '2026-08-13',
                'so_cho' => 40,
                'so_cho_da_dat' => 18,
                'so_cho_con_lai' => 22,
                'gia_nguoi_lon' => 5200000,
                'gia_tre_em' => 4100000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 2,
                'huong_dan_vien_id' => 1,
                'ngay_khoi_hanh' => '2026-08-14',
                'ngay_ket_thuc' => '2026-08-17',
                'so_cho' => 40,
                'so_cho_da_dat' => 32,
                'so_cho_con_lai' => 8,
                'gia_nguoi_lon' => 5200000,
                'gia_tre_em' => 4100000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tour_id' => 2,
                'huong_dan_vien_id' => null,
                'ngay_khoi_hanh' => '2026-08-18',
                'ngay_ket_thuc' => '2026-08-21',
                'so_cho' => 40,
                'so_cho_da_dat' => 40,
                'so_cho_con_lai' => 0,
                'gia_nguoi_lon' => 5200000,
                'gia_tre_em' => 4100000,
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
