<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            //DanhMucSeeder::class,
            //DanhSachTourSeeder::class,
            //UserSeeder::class,
            //HuongDanVienSeeder::class,
            PhuongTienSeeder::class,
            LichKhoiHanhTourSeeder::class,
            DatTourSeeder::class, // thêm dòng này

        ]);
    }
}
