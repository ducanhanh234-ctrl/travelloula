<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\DanhSachTour;

class LichKhoiHanhTourSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh sách tour thật từ database
        $tours = DanhSachTour::all();

        if ($tours->isEmpty()) {
            return; // tránh lỗi FK nếu chưa có tour
        }

        $data = [];

        foreach ($tours as $tour) {
            $data[] = [
                'tour_id' => $tour->id,
                'ngay_khoi_hanh' => Carbon::now()->addDays(rand(3, 20)),
                'so_cho' => rand(15, 30),
                'gia_nguoi_lon' => rand(1500000, 3500000),
                'gia_tre_em' => rand(1000000, 2500000),
                'trang_thai' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // mỗi tour tạo thêm 1 lịch nữa (tuỳ bạn)
            $data[] = [
                'tour_id' => $tour->id,
                'ngay_khoi_hanh' => Carbon::now()->addDays(rand(21, 40)),
                'so_cho' => rand(15, 30),
                'gia_nguoi_lon' => rand(1500000, 3500000),
                'gia_tre_em' => rand(1000000, 2500000),
                'trang_thai' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('lich_khoi_hanh_tours')->insert($data);
    }
}
