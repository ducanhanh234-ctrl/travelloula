<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhuongTien;

class PhuongTienSeeder extends Seeder
{
    public function run(): void
    {
        PhuongTien::insert([
            [
                'bien_so_xe' => '29A-12345',
                'loai_phuong_tien' => 'Xe 16 chỗ',
                'hang_xe' => 'Ford Transit',
                'nam_san_xuat' => 2022,
                'mau_xe' => 'Trắng',
                'trang_thai' => 1,
                'ten_tai_xe' => 'Nguyễn Văn Hải',
                'so_dien_thoai_tai_xe' => '0988888888',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bien_so_xe' => '30B-67890',
                'loai_phuong_tien' => 'Xe 29 chỗ',
                'hang_xe' => 'Hyundai County',
                'nam_san_xuat' => 2021,
                'mau_xe' => 'Đỏ',
                'trang_thai' => 1,
                'ten_tai_xe' => 'Trần Văn Nam',
                'so_dien_thoai_tai_xe' => '0977777777',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
