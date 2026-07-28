<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\DanhMuc;

class DanhMucSeeder extends Seeder
{
    // public function run(): void
    // {
    //     DB::table('danh_mucs')->insert([
    //         [
    //             'ten_danh_muc' => 'Tour biển',
    //             'mo_ta' => 'Du lịch biển đảo',
    //             'hinh_anh' => null,
    //             'trang_thai' => 'active',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //         [
    //             'ten_danh_muc' => 'Tour núi',
    //             'mo_ta' => 'Du lịch khám phá núi rừng',
    //             'hinh_anh' => null,
    //             'trang_thai' => 'active',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ],
    //     ]);
    // }
    public function run(): void
    {
        $categories = [
            [
                'ten_danh_muc' => 'Tour biển',
                'mo_ta' => 'Du lịch biển đảo',
                'hinh_anh' => null,
                'trang_thai' => 'active',
            ],
            [
                'ten_danh_muc' => 'Tour núi',
                'mo_ta' => 'Du lịch khám phá núi rừng',
                'hinh_anh' => null,
                'trang_thai' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            DanhMuc::updateOrCreate(
                [
                    'ten_danh_muc' => $category['ten_danh_muc'],
                ],
                $category
            );
        }
    }
}
