<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LichKhoiHanhSeeder extends Seeder
{
    public function run(): void
    {
        $tours = DB::table('danh_sach_tours')->get();
        foreach ($tours as $tour) {
            $exists = DB::table('lich_khoi_hanh_tours')
                ->where('tour_id', $tour->id)
                ->exists();
            if ($exists) {
                continue;
            }
            DB::table('lich_khoi_hanh_tours')->insert([
                'tour_id' => $tour->id,
                'ngay_khoi_hanh' => now()->addDays(rand(5, 30)),
                'ngay_ket_thuc' => now()->addDays(rand(31, 40)),
                'so_cho_con_lai' => rand(20, 40),
                'so_cho_da_dat' => rand(0, 10),
                'huong_dan_vien_id' => rand(1, 4),
                'phuong_tien_id' => rand(1, 7),
                'trang_thai' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
