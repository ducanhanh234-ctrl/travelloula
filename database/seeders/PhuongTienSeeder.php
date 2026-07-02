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
                'bien_so_xe' => '29B-12345',
                'trang_thai' => '1',
                'hang_xe' => 'honda',
                'mau_xe' => 'xanh',
                'nam_san_xuat' => 2026,
                'loai_phuong_tien' => '180 chỗ',
                'ten_tai_xe' => 'admin',
                'so_dien_thoai_tai_xe' => '0123456789',
                'ghi_chu' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'ten_phuong_tien' => 'Xe du lịch 45 chỗ',
                'so_cho' => 45,
                'bien_so' => '29B-12345',
                'bien_so_xe' => '29B-12345',
                'trang_thai' => '1',
                'hang_xe' => 'honda',
                'mau_xe' => 'xanh',
                'nam_san_xuat' => 2026,
                'loai_phuong_tien' => '45 chỗ',
                'ten_tai_xe' => 'admin',
                'so_dien_thoai_tai_xe' => '0123456789',
                'ghi_chu' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
