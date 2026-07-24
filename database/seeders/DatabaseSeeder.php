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
    $adminRole = VaiTro::firstOrCreate(
        ['ten_vai_tro' => 'admin'],
        ['mo_ta' => 'Quản trị viên hệ thống']
    );

    $guideRole = VaiTro::firstOrCreate(
        ['ten_vai_tro' => 'guide'],
        ['mo_ta' => 'Hướng dẫn viên']
    );

    // Admin có toàn bộ quyền
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

        $adminUser = User::where('email', 'admin@gmail.com')->first();

        if ($adminUser) {
            $adminUser->vaiTros()->syncWithoutDetaching([$adminRole->id]);
        }
        
    }

