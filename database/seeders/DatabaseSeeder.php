<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VaiTro;
use App\Models\QuyenHan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        $adminRole = VaiTro::firstOrCreate(
            ['ten_vai_tro' => 'admin'],
            ['mo_ta' => 'Quản trị viên hệ thống']
        );

        $guideRole = VaiTro::firstOrCreate(
            ['ten_vai_tro' => 'guide'],
            ['mo_ta' => 'Hướng dẫn viên']
        );

        $manageUsers = QuyenHan::firstOrCreate(
            ['ten' => 'manage_users'],
            ['ten_hien_thi' => 'Quản lý người dùng', 'mo_ta' => 'Cho phép quản lý tài khoản người dùng', 'mo_dun' => 'users', 'trang_thai' => true]
        );

        $manageRoles = QuyenHan::firstOrCreate(
            ['ten' => 'manage_roles'],
            ['ten_hien_thi' => 'Quản lý vai trò', 'mo_ta' => 'Cho phép quản lý vai trò và quyền', 'mo_dun' => 'roles', 'trang_thai' => true]
        );

        $accessAdmin = QuyenHan::firstOrCreate(
            ['ten' => 'vao_admin'],
            ['ten_hien_thi' => 'Truy cập Admin', 'mo_ta' => 'Cho phép truy cập khu vực quản trị', 'mo_dun' => 'system', 'trang_thai' => true]
        );

        $accessGuide = QuyenHan::firstOrCreate(
            ['ten' => 'vao_guide'],
            ['ten_hien_thi' => 'Truy cập Guide', 'mo_ta' => 'Cho phép truy cập khu vực hướng dẫn viên', 'mo_dun' => 'system', 'trang_thai' => true]
        );

        $adminRole->quyenHans()->syncWithoutDetaching([$manageUsers->id, $manageRoles->id, $accessAdmin->id]);
        $guideRole->quyenHans()->syncWithoutDetaching([$accessGuide->id]);
    }
}
