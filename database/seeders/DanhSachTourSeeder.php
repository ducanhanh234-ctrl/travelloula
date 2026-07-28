<?php

namespace Database\Seeders;

use App\Models\DanhSachTour;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class DanhSachTourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            [
                'danh_muc_id' => 1,
                'ten_tour' => 'Tour Đà Nẵng 3N2Đ',
                'duong_dan' => Str::slug('Tour nang da'),

                'gia_tour' => 3500000,
                'gia_nguoi_lon' => 3500000,
                'gia_tre_em' => 2625000,
                'gia_em_be' => 1050000,

                'thoi_luong' => '3 ngày 2 đêm',
                'dia_diem_khoi_hanh' => 'Hà Nội',
                'diem_den' => 'Đà Nẵng',
                'so_khach_toi_da' => 30,
                'phuong_tien' => 'Máy bay',
                'trang_thai' => 'active',
            ],

            [
                'danh_muc_id' => 1,
                'ten_tour' => 'Tour Nha Trang 2',
                'duong_dan' => Str::slug('tour trang nha'),

                'gia_tour' => 4200000,
                'gia_nguoi_lon' => 4200000,
                'gia_tre_em' => 3150000,
                'gia_em_be' => 1260000,

                'thoi_luong' => '4 ngày 3 đêm',
                'dia_diem_khoi_hanh' => 'Hà Nội',
                'diem_den' => 'Nha Trang',
                'so_khach_toi_da' => 40,
                'phuong_tien' => 'Máy bay',
                'trang_thai' => 'active',
            ],

            [
                'danh_muc_id' => 1,
                'ten_tour' => 'Tour Phú Quốc',
                'duong_dan' => Str::slug('tour quoc phu'),

                'gia_tour' => 5500000,
                'gia_nguoi_lon' => 5500000,
                'gia_tre_em' => 4125000,
                'gia_em_be' => 1650000,

                'thoi_luong' => '4 ngày 3 đêm',
                'dia_diem_khoi_hanh' => 'Hà Nội',
                'diem_den' => 'Phú Quốc',
                'so_khach_toi_da' => 35,
                'phuong_tien' => 'Máy bay',
                'trang_thai' => 'active',
            ],
        ];

        foreach ($tours as $tour) {
            DanhSachTour::updateOrCreate(
                [
                    'duong_dan' => $tour['duong_dan'],
                ],
                $tour
            );
        }
    }
}
