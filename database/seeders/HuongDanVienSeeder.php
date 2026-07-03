<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HuongDanVienSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('huong_dan_viens')->insert([
            [
                'user_id' => 1,
                'ho_ten' => 'Nguyễn Văn A',
                'email' => 'hdv1@gmail.com',
                'so_dien_thoai' => '0900000001',
                'so_nam_kinh_nghiem' => 5,
                'trang_thai' => 'hoat_dong',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'ho_ten' => 'Nguyễn Văn B',
                'email' => 'hdv2@gmail.com',
                'so_dien_thoai' => '0900000002',
                'so_nam_kinh_nghiem' => 3,
                'trang_thai' => 'hoat_dong',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
