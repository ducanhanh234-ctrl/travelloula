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
            [
                'ten_hien_thi' => 'Quản lý người dùng',
                'mo_ta' => 'Cho phép quản lý tài khoản người dùng',
                'mo_dun' => 'users',
                'trang_thai' => true,
            ]
        );

        $manageRoles = QuyenHan::firstOrCreate(
            ['ten' => 'manage_roles'],
            [
                'ten_hien_thi' => 'Quản lý vai trò',
                'mo_ta' => 'Cho phép quản lý vai trò và quyền',
                'mo_dun' => 'roles',
                'trang_thai' => true,
            ]
        );

        $accessAdmin = QuyenHan::firstOrCreate(
            ['ten' => 'vao_admin'],
            [
                'ten_hien_thi' => 'Truy cập Admin',
                'mo_ta' => 'Cho phép truy cập khu vực quản trị',
                'mo_dun' => 'system',
                'trang_thai' => true,
            ]
        );

        $accessGuide = QuyenHan::firstOrCreate(
            ['ten' => 'vao_guide'],
            [
                'ten_hien_thi' => 'Truy cập Guide',
                'mo_ta' => 'Cho phép truy cập khu vực hướng dẫn viên',
                'mo_dun' => 'system',
                'trang_thai' => true,
            ]
        );

        $bannerView = QuyenHan::firstOrCreate(
            ['ten' => 'banners.view'],
            [
                'ten_hien_thi' => 'Xem banner',
                'mo_ta' => 'Xem danh sách banner',
                'mo_dun' => 'banners',
                'trang_thai' => true,
            ]
        );

        $bannerCreate = QuyenHan::firstOrCreate(
            ['ten' => 'banners.create'],
            [
                'ten_hien_thi' => 'Tạo banner',
                'mo_ta' => 'Tạo banner mới',
                'mo_dun' => 'banners',
                'trang_thai' => true,
            ]
        );

        $bannerEdit = QuyenHan::firstOrCreate(
            ['ten' => 'banners.edit'],
            [
                'ten_hien_thi' => 'Sửa banner',
                'mo_ta' => 'Chỉnh sửa banner',
                'mo_dun' => 'banners',
                'trang_thai' => true,
            ]
        );

        $bannerDelete = QuyenHan::firstOrCreate(
            ['ten' => 'banners.delete'],
            [
                'ten_hien_thi' => 'Xóa banner',
                'mo_ta' => 'Xóa banner',
                'mo_dun' => 'banners',
                'trang_thai' => true,
            ]
        );

        $danhMucView = QuyenHan::firstOrCreate(
            ['ten' => 'danh_mucs.view'],
            [
                'ten_hien_thi' => 'Xem danh mục',
                'mo_ta' => 'Xem danh sách danh mục',
                'mo_dun' => 'danh_mucs',
                'trang_thai' => true,
            ]
        );

        $danhMucCreate = QuyenHan::firstOrCreate(
            ['ten' => 'danh_mucs.create'],
            [
                'ten_hien_thi' => 'Tạo danh mục',
                'mo_ta' => 'Tạo danh mục mới',
                'mo_dun' => 'danh_mucs',
                'trang_thai' => true,
            ]
        );

        $danhMucEdit = QuyenHan::firstOrCreate(
            ['ten' => 'danh_mucs.edit'],
            [
                'ten_hien_thi' => 'Sửa danh mục',
                'mo_ta' => 'Chỉnh sửa danh mục',
                'mo_dun' => 'danh_mucs',
                'trang_thai' => true,
            ]
        );

        $danhMucDelete = QuyenHan::firstOrCreate(
            ['ten' => 'danh_mucs.delete'],
            [
                'ten_hien_thi' => 'Xóa danh mục',
                'mo_ta' => 'Xóa danh mục',
                'mo_dun' => 'danh_mucs',
                'trang_thai' => true,
            ]
        );

        $phuongTienView = QuyenHan::firstOrCreate(
            ['ten' => 'phuong_tiens.view'],
            [
                'ten_hien_thi' => 'Xem phương tiện',
                'mo_ta' => 'Xem danh sách phương tiện',
                'mo_dun' => 'phuong_tiens',
                'trang_thai' => true,
            ]
        );

        $phuongTienCreate = QuyenHan::firstOrCreate(
            ['ten' => 'phuong_tiens.create'],
            [
                'ten_hien_thi' => 'Tạo phương tiện',
                'mo_ta' => 'Tạo phương tiện mới',
                'mo_dun' => 'phuong_tiens',
                'trang_thai' => true,
            ]
        );

        $phuongTienEdit = QuyenHan::firstOrCreate(
            ['ten' => 'phuong_tiens.edit'],
            [
                'ten_hien_thi' => 'Sửa phương tiện',
                'mo_ta' => 'Chỉnh sửa phương tiện',
                'mo_dun' => 'phuong_tiens',
                'trang_thai' => true,
            ]
        );

        $phuongTienDelete = QuyenHan::firstOrCreate(
            ['ten' => 'phuong_tiens.delete'],
            [
                'ten_hien_thi' => 'Xóa phương tiện',
                'mo_ta' => 'Xóa phương tiện',
                'mo_dun' => 'phuong_tiens',
                'trang_thai' => true,
            ]
        );

        $phanCongView = QuyenHan::firstOrCreate(
            ['ten' => 'phan_cong.view'],
            [
                'ten_hien_thi' => 'Xem phân công',
                'mo_ta' => 'Xem danh sách phân công',
                'mo_dun' => 'phan_cong',
                'trang_thai' => true,
            ]
        );

        $phanCongCreate = QuyenHan::firstOrCreate(
            ['ten' => 'phan_cong.create'],
            [
                'ten_hien_thi' => 'Tạo phân công',
                'mo_ta' => 'Tạo phân công mới',
                'mo_dun' => 'phan_cong',
                'trang_thai' => true,
            ]
        );

        $phanCongEdit = QuyenHan::firstOrCreate(
            ['ten' => 'phan_cong.edit'],
            [
                'ten_hien_thi' => 'Sửa phân công',
                'mo_ta' => 'Chỉnh sửa phân công',
                'mo_dun' => 'phan_cong',
                'trang_thai' => true,
            ]
        );

        $phanCongDelete = QuyenHan::firstOrCreate(
            ['ten' => 'phan_cong.delete'],
            [
                'ten_hien_thi' => 'Xóa phân công',
                'mo_ta' => 'Xóa phân công',
                'mo_dun' => 'phan_cong',
                'trang_thai' => true,
            ]
        );

        $lichKhoiHanhView = QuyenHan::firstOrCreate(
            ['ten' => 'lich_khoi_hanh.view'],
            [
                'ten_hien_thi' => 'Xem lịch khởi hành',
                'mo_ta' => 'Xem danh sách lịch khởi hành',
                'mo_dun' => 'lich_khoi_hanh',
                'trang_thai' => true,
            ]
        );

        $lichKhoiHanhCreate = QuyenHan::firstOrCreate(
            ['ten' => 'lich_khoi_hanh.create'],
            [
                'ten_hien_thi' => 'Tạo lịch khởi hành',
                'mo_ta' => 'Tạo lịch khởi hành mới',
                'mo_dun' => 'lich_khoi_hanh',
                'trang_thai' => true,
            ]
        );

        $lichKhoiHanhEdit = QuyenHan::firstOrCreate(
            ['ten' => 'lich_khoi_hanh.edit'],
            [
                'ten_hien_thi' => 'Sửa lịch khởi hành',
                'mo_ta' => 'Chỉnh sửa lịch khởi hành',
                'mo_dun' => 'lich_khoi_hanh',
                'trang_thai' => true,
            ]
        );

        $lichKhoiHanhDelete = QuyenHan::firstOrCreate(
            ['ten' => 'lich_khoi_hanh.delete'],
            [
                'ten_hien_thi' => 'Xóa lịch khởi hành',
                'mo_ta' => 'Xóa lịch khởi hành',
                'mo_dun' => 'lich_khoi_hanh',
                'trang_thai' => true,
            ]
        );

        $gopDoanView = QuyenHan::firstOrCreate(
            ['ten' => 'gop_doan.view'],
            [
                'ten_hien_thi' => 'Xem gộp đoàn',
                'mo_ta' => 'Xem danh sách gộp đoàn',
                'mo_dun' => 'gop_doan',
                'trang_thai' => true,
            ]
        );

        $gopDoanCreate = QuyenHan::firstOrCreate(
            ['ten' => 'gop_doan.create'],
            [
                'ten_hien_thi' => 'Tạo gộp đoàn',
                'mo_ta' => 'Tạo yêu cầu gộp đoàn mới',
                'mo_dun' => 'gop_doan',
                'trang_thai' => true,
            ]
        );

        $gopDoanEdit = QuyenHan::firstOrCreate(
            ['ten' => 'gop_doan.edit'],
            [
                'ten_hien_thi' => 'Sửa gộp đoàn',
                'mo_ta' => 'Cập nhật yêu cầu gộp đoàn',
                'mo_dun' => 'gop_doan',
                'trang_thai' => true,
            ]
        );

        $gopDoanDelete = QuyenHan::firstOrCreate(
            ['ten' => 'gop_doan.delete'],
            [
                'ten_hien_thi' => 'Xóa gộp đoàn',
                'mo_ta' => 'Hủy yêu cầu gộp đoàn',
                'mo_dun' => 'gop_doan',
                'trang_thai' => true,
            ]
        );

        $adminRole->quyenHans()->syncWithoutDetaching([
            $manageUsers->id,
            $manageRoles->id,
            $accessAdmin->id,
            $bannerView->id,
            $bannerCreate->id,
            $bannerEdit->id,
            $bannerDelete->id,
            $danhMucView->id,
            $danhMucCreate->id,
            $danhMucEdit->id,
            $danhMucDelete->id,
            $phuongTienView->id,
            $phuongTienCreate->id,
            $phuongTienEdit->id,
            $phuongTienDelete->id,
            $phanCongView->id,
            $phanCongCreate->id,
            $phanCongEdit->id,
            $phanCongDelete->id,
            $lichKhoiHanhView->id,
            $lichKhoiHanhCreate->id,
            $lichKhoiHanhEdit->id,
            $lichKhoiHanhDelete->id,
            $gopDoanView->id,
            $gopDoanCreate->id,
            $gopDoanEdit->id,
            $gopDoanDelete->id,
        ]);

        $guideRole->quyenHans()->syncWithoutDetaching([
            $accessGuide->id,
        ]);

        $this->call([
            DanhMucSeeder::class,
            DanhSachTourSeeder::class,

            UserSeeder::class,
            HuongDanVienSeeder::class,

            PhuongTienSeeder::class,

            LichKhoiHanhTourSeeder::class,
            DatTourSeeder::class,
        ]);
    }
}
