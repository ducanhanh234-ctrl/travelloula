<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PhuongTien;


class PhuongTienSeeder extends Seeder
{
    // public function run(): void
    // {

    //     DB::table('phuong_tiens')->insert([
    //         [
    //             'so_cho' => 29,
    //             'bien_so_xe' => '29A-12345',
    //             'trang_thai' => '1',
    //             'hang_xe' => 'honda',
    //             'mau_xe' => 'xanh',
    //             'nam_san_xuat' => 2026,
    //             'loai_xe' => 'Xe khách',
    //             'loai_phuong_tien' => '29 chỗ',
    //             'ten_tai_xe' => 'admin',
    //             'so_dien_thoai_tai_xe' => '0123456789',
    //             'ghi_chu' => null,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         [
    //             'so_cho' => 45,
    //             'bien_so_xe' => '29B-12345',
    //             'trang_thai' => '1',
    //             'hang_xe' => 'honda',
    //             'mau_xe' => 'Đỏ',
    //             'nam_san_xuat' => 2026,
    //             'loai_xe' => 'Xe khách',
    //             'loai_phuong_tien' => '45 chỗ',
    //             'ten_tai_xe' => 'admin',
    //             'so_dien_thoai_tai_xe' => '0123456789',
    //             'ghi_chu' => null,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],

    //     ]);
    // }

    public function run(): void
    {
        $vehicles = [
            [
                'so_cho' => 29,
                'bien_so_xe' => '29A-12345',
                'trang_thai' => '1',
                'hang_xe' => 'Honda',
                'mau_xe' => 'Xanh',
                'nam_san_xuat' => 2026,
                'loai_xe' => 'Xe khách',
                'loai_phuong_tien' => '29 chỗ',
                'ten_tai_xe' => 'admin',
                'so_dien_thoai_tai_xe' => '0123456789',
                'ghi_chu' => null,
            ],
            [
                'so_cho' => 45,
                'bien_so_xe' => '29B-12345',
                'trang_thai' => '1',
                'hang_xe' => 'Honda',
                'mau_xe' => 'Đỏ',
                'nam_san_xuat' => 2026,
                'loai_xe' => 'Xe khách',
                'loai_phuong_tien' => '45 chỗ',
                'ten_tai_xe' => 'admin',
                'so_dien_thoai_tai_xe' => '0123456789',
                'ghi_chu' => null,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            PhuongTien::updateOrCreate(
                [
                    'bien_so_xe' => $vehicle['bien_so_xe'],
                ],
                $vehicle
            );
        }
    }
}
