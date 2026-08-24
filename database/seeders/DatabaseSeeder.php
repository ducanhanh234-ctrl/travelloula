<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VaiTro;
use App\Models\QuyenHan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            PermissionSeeder::class,

            DanhMucSeeder::class,
            DanhSachTourSeeder::class,

            BangGiaTourSeeder::class,

            UserSeeder::class,
            HuongDanVienSeeder::class,

            PhuongTienSeeder::class,

            LichKhoiHanhTourSeeder::class,

            DatTourSeeder::class,
        ]);


        $adminRole = VaiTro::firstOrCreate(
            ['ten_vai_tro' => 'admin'],
            ['mo_ta' => 'Quản trị viên hệ thống']
        );

        $guideRole = VaiTro::firstOrCreate(
            ['ten_vai_tro' => 'guide'],
            ['mo_ta' => 'Hướng dẫn viên']
        );

        $userRole = VaiTro::firstOrCreate(
            ['ten_vai_tro' => 'User'],
            ['mo_ta' => 'Khách hàng']
        );

        // Admin có toàn bộ quyền

        $adminRole->quyenHans()->sync(
            QuyenHan::pluck('id')->toArray()
        );

        // Guide có các quyền cần thiết
        $guideRole->quyenHans()->sync(
            QuyenHan::whereIn('ten', [
                'vao_guide',
                'phuong_tiens.view',
            ])->pluck('id')->toArray()
        );

        $allPermissions = QuyenHan::pluck('id')->toArray();
        $adminRole->quyenHans()->syncWithoutDetaching($allPermissions);

        // Guide chỉ có quyền vào khu vực Guide
        $guidePermissionIds = QuyenHan::whereIn('ten', [
            'vao_guide',
            'phuong_tiens.view',
        ])->pluck('id')->toArray();

        $guideRole->quyenHans()->syncWithoutDetaching($guidePermissionIds);

        $this->call([
            DanhMucSeeder::class,
            DanhSachTourSeeder::class,
            UserSeeder::class,
            HuongDanVienSeeder::class,
            PhuongTienSeeder::class,
            LichKhoiHanhTourSeeder::class,
            DatTourSeeder::class,
        ]);


        // Gán role admin cho tài khoản admin@gmail.com
        $adminUser = User::where('email', 'admin@gmail.com')->first();

        if ($adminUser) {
            $adminUser->vaiTros()->sync([$adminRole->id]);
        }



    }
}


