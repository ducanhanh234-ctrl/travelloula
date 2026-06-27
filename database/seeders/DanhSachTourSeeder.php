<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DanhSachTourSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('danh_sach_tours')->insert([
            [
                'danh_muc_id' => 1,
                'ten_tour' => 'Tour Đà Nẵng 3N2Đ',
                'duong_dan' => Str::slug('Tour Đà Nẵng 3N2Đ'),
                'gia_tour' => 3500000,
                'thoi_luong' => '3 ngày 2 đêm',
                'dia_diem_khoi_hanh' => 'Hà Nội',
                'diem_den' => 'Đà Nẵng',
                'so_khach_toi_da' => 30,
                'phuong_tien' => 'Máy bay',
                'trang_thai' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'danh_muc_id' => 1,
                'ten_tour' => 'Tour Nha Trang',
                'duong_dan' => Str::slug('Tour Nha Trang'),
                'gia_tour' => 4200000,
                'thoi_luong' => '4 ngày 3 đêm',
                'dia_diem_khoi_hanh' => 'Hà Nội',
                'diem_den' => 'Nha Trang',
                'so_khach_toi_da' => 40,
                'phuong_tien' => 'Máy bay',
                'trang_thai' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'danh_muc_id' => 1,
                'ten_tour' => 'Tour Phú Quốc',
                'duong_dan' => Str::slug('Tour Phú Quốc'),
                'gia_tour' => 5500000,
                'thoi_luong' => '4 ngày 3 đêm',
                'dia_diem_khoi_hanh' => 'Hà Nội',
                'diem_den' => 'Phú Quốc',
                'so_khach_toi_da' => 35,
                'phuong_tien' => 'Máy bay',
                'trang_thai' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
