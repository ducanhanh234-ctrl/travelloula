<?php

namespace Database\Seeders;

use App\Models\BangGiaTour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BangGiaTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BangGiaTour::insert([

            [
                'tour_id' => 1,
                'loai_mua' => 'thuong',

                'gia_nguoi_lon' => 3500000,
                'gia_tre_em' => 2625000,
                'gia_em_be' => 1050000,
            ],

            [
                'tour_id' => 1,
                'loai_mua' => 'cao_diem',

                'gia_nguoi_lon' => 4300000,
                'gia_tre_em' => 3225000,
                'gia_em_be' => 1290000,
            ],

            [
                'tour_id' => 2,
                'loai_mua' => 'thuong',

                'gia_nguoi_lon' => 4200000,
                'gia_tre_em' => 3150000,
                'gia_em_be' => 1260000,
            ],

            [
                'tour_id' => 2,
                'loai_mua' => 'cao_diem',

                'gia_nguoi_lon' => 5200000,
                'gia_tre_em' => 3900000,
                'gia_em_be' => 1560000,
            ],

            [
                'tour_id' => 3,
                'loai_mua' => 'thuong',

                'gia_nguoi_lon' => 5500000,
                'gia_tre_em' => 4125000,
                'gia_em_be' => 1650000,
            ],

            [
                'tour_id' => 3,
                'loai_mua' => 'cao_diem',

                'gia_nguoi_lon' => 6800000,
                'gia_tre_em' => 5100000,
                'gia_em_be' => 2040000,
            ],
        ]);
    }
}
