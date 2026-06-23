<?php

namespace Database\Seeders;

use App\Models\QuyenHan;
use App\Models\VaiTro;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Users
            ['ten' => 'users.view', 'ten_hien_thi' => 'Xem người dùng', 'mo_dun' => 'users', 'mo_ta' => 'Xem danh sách và chi tiết người dùng'],
            ['ten' => 'users.create', 'ten_hien_thi' => 'Tạo người dùng', 'mo_dun' => 'users', 'mo_ta' => 'Tạo tài khoản người dùng mới'],
            ['ten' => 'users.edit', 'ten_hien_thi' => 'Sửa người dùng', 'mo_dun' => 'users', 'mo_ta' => 'Chỉnh sửa thông tin người dùng'],
            ['ten' => 'users.delete', 'ten_hien_thi' => 'Xóa người dùng', 'mo_dun' => 'users', 'mo_ta' => 'Xóa tài khoản người dùng'],

            // Roles
            ['ten' => 'roles.view', 'ten_hien_thi' => 'Xem vai trò', 'mo_dun' => 'roles', 'mo_ta' => 'Xem danh sách vai trò'],
            ['ten' => 'roles.create', 'ten_hien_thi' => 'Tạo vai trò', 'mo_dun' => 'roles', 'mo_ta' => 'Tạo vai trò mới'],
            ['ten' => 'roles.edit', 'ten_hien_thi' => 'Sửa vai trò', 'mo_dun' => 'roles', 'mo_ta' => 'Chỉnh sửa vai trò'],
            ['ten' => 'roles.delete', 'ten_hien_thi' => 'Xóa vai trò', 'mo_dun' => 'roles', 'mo_ta' => 'Xóa vai trò'],

            // Permissions
            ['ten' => 'permissions.view', 'ten_hien_thi' => 'Xem quyền', 'mo_dun' => 'permissions', 'mo_ta' => 'Xem danh sách quyền'],
            ['ten' => 'permissions.create', 'ten_hien_thi' => 'Tạo quyền', 'mo_dun' => 'permissions', 'mo_ta' => 'Tạo quyền mới'],
            ['ten' => 'permissions.edit', 'ten_hien_thi' => 'Sửa quyền', 'mo_dun' => 'permissions', 'mo_ta' => 'Chỉnh sửa quyền'],
            ['ten' => 'permissions.delete', 'ten_hien_thi' => 'Xóa quyền', 'mo_dun' => 'permissions', 'mo_ta' => 'Xóa quyền'],

            // Tours
            ['ten' => 'tours.view', 'ten_hien_thi' => 'Xem tour', 'mo_dun' => 'tours', 'mo_ta' => 'Xem danh sách tour'],
            ['ten' => 'tours.create', 'ten_hien_thi' => 'Tạo tour', 'mo_dun' => 'tours', 'mo_ta' => 'Tạo tour mới'],
            ['ten' => 'tours.edit', 'ten_hien_thi' => 'Sửa tour', 'mo_dun' => 'tours', 'mo_ta' => 'Chỉnh sửa tour'],
            ['ten' => 'tours.delete', 'ten_hien_thi' => 'Xóa tour', 'mo_dun' => 'tours', 'mo_ta' => 'Xóa tour'],

            // Bookings
            ['ten' => 'bookings.view', 'ten_hien_thi' => 'Xem đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Xem danh sách đặt tour'],
            ['ten' => 'bookings.create', 'ten_hien_thi' => 'Tạo đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Tạo đặt tour mới'],
            ['ten' => 'bookings.edit', 'ten_hien_thi' => 'Sửa đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Chỉnh sửa đặt tour'],
            ['ten' => 'bookings.delete', 'ten_hien_thi' => 'Xóa đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Xóa đặt tour'],
            
            // Guides
            ['ten' => 'guides.view', 'ten_hien_thi' => 'Xem hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Xem danh sách và chi tiết hướng dẫn viên'],
            ['ten' => 'guides.create', 'ten_hien_thi' => 'Tạo hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Tạo hướng dẫn viên mới'],
            ['ten' => 'guides.edit', 'ten_hien_thi' => 'Sửa hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Chỉnh sửa hướng dẫn viên'],
            ['ten' => 'guides.delete', 'ten_hien_thi' => 'Xóa hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Xóa hướng dẫn viên'],

            // Payments
            ['ten' => 'payments.view', 'ten_hien_thi' => 'Xem thanh toán', 'mo_dun' => 'payments', 'mo_ta' => 'Xem danh sách thanh toán'],
            ['ten' => 'payments.edit', 'ten_hien_thi' => 'Cập nhật thanh toán', 'mo_dun' => 'payments', 'mo_ta' => 'Cập nhật trạng thái thanh toán'],

            // Reports
            ['ten' => 'reports.view', 'ten_hien_thi' => 'Xem báo cáo', 'mo_dun' => 'reports', 'mo_ta' => 'Xem báo cáo thống kê'],

            // System access
            ['ten' => 'vao_admin', 'ten_hien_thi' => 'Truy cập Admin', 'mo_dun' => 'system', 'mo_ta' => 'Quyền truy cập khu vực quản trị'],
            ['ten' => 'vao_guide', 'ten_hien_thi' => 'Truy cập Guide', 'mo_dun' => 'system', 'mo_ta' => 'Quyền truy cập khu vực hướng dẫn viên'],
        ];

        foreach ($permissions as $permission) {
            QuyenHan::firstOrCreate(
                ['ten' => $permission['ten']],
                array_merge($permission, ['trang_thai' => true])
            );
        }
    }
}
