<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            UserSeeder::class,

            DanhMucSeeder::class,

            DanhSachTourSeeder::class,

            PhuongTienSeeder::class,

            HuongDanVienSeeder::class,

            LichKhoiHanhTourSeeder::class,

            DatTourSeeder::class,

        ]);
    }
}
