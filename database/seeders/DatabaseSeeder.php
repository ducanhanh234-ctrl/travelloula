<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DanhMucSeeder::class,
            DanhSachTourSeeder::class,
            UserSeeder::class,
            HuongDanVienSeeder::class,
            PhuongTienSeeder::class,
            LichKhoiHanhTourSeeder::class,
            DatTourSeeder::class, // thêm dòng này
        ]);
    }
}
