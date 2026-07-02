<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use App\Models\PhuongTien;


class PhuongTienSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('phuong_tiens')->insert([
            [
                'ten_phuong_tien' => 'Máy bay Vietnam Airlines',
                'so_cho' => 180,
                'bien_so' => null,
                'trang_thai' => 'san_sang',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'ten_phuong_tien' => 'Xe du lịch 45 chỗ',
                'so_cho' => 45,
                'bien_so' => '29B-12345',
                'trang_thai' => 'san_sang',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
