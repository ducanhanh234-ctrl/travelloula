<?php

namespace Database\Seeders;

use App\Models\QuyenHan;
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

            // Lịch trình tour
            ['ten' => 'lich_trinh_tours.view', 'ten_hien_thi' => 'Xem lịch trình tour', 'mo_dun' => 'lich_trinh_tours', 'mo_ta' => 'Xem danh sách lịch trình tour'],
            ['ten' => 'lich_trinh_tours.create', 'ten_hien_thi' => 'Tạo lịch trình tour', 'mo_dun' => 'lich_trinh_tours', 'mo_ta' => 'Tạo lịch trình tour mới'],
            ['ten' => 'lich_trinh_tours.edit', 'ten_hien_thi' => 'Sửa lịch trình tour', 'mo_dun' => 'lich_trinh_tours', 'mo_ta' => 'Chỉnh sửa lịch trình tour'],
            ['ten' => 'lich_trinh_tours.delete', 'ten_hien_thi' => 'Xóa lịch trình tour', 'mo_dun' => 'lich_trinh_tours', 'mo_ta' => 'Xóa lịch trình tour'],

            // Chi tiết lịch trình
            ['ten' => 'chi_tiet_lich_trinhs.view', 'ten_hien_thi' => 'Xem chi tiết lịch trình', 'mo_dun' => 'chi_tiet_lich_trinhs', 'mo_ta' => 'Xem chi tiết lịch trình tour'],
            ['ten' => 'chi_tiet_lich_trinhs.create', 'ten_hien_thi' => 'Tạo chi tiết lịch trình', 'mo_dun' => 'chi_tiet_lich_trinhs', 'mo_ta' => 'Tạo chi tiết lịch trình mới'],
            ['ten' => 'chi_tiet_lich_trinhs.edit', 'ten_hien_thi' => 'Sửa chi tiết lịch trình', 'mo_dun' => 'chi_tiet_lich_trinhs', 'mo_ta' => 'Chỉnh sửa chi tiết lịch trình'],
            ['ten' => 'chi_tiet_lich_trinhs.delete', 'ten_hien_thi' => 'Xóa chi tiết lịch trình', 'mo_dun' => 'chi_tiet_lich_trinhs', 'mo_ta' => 'Xóa chi tiết lịch trình'],

            // Lịch khởi hành
            ['ten' => 'lich_khoi_hanh.view', 'ten_hien_thi' => 'Xem lịch khởi hành', 'mo_dun' => 'lich_khoi_hanh', 'mo_ta' => 'Xem danh sách lịch khởi hành'],
            ['ten' => 'lich_khoi_hanh.create', 'ten_hien_thi' => 'Tạo lịch khởi hành', 'mo_dun' => 'lich_khoi_hanh', 'mo_ta' => 'Tạo lịch khởi hành mới'],
            ['ten' => 'lich_khoi_hanh.edit', 'ten_hien_thi' => 'Sửa lịch khởi hành', 'mo_dun' => 'lich_khoi_hanh', 'mo_ta' => 'Chỉnh sửa lịch khởi hành'],
            ['ten' => 'lich_khoi_hanh.delete', 'ten_hien_thi' => 'Xóa lịch khởi hành', 'mo_dun' => 'lich_khoi_hanh', 'mo_ta' => 'Xóa lịch khởi hành'],

            // Nhật ký tour
            ['ten' => 'nhat_ky_tours.view', 'ten_hien_thi' => 'Xem nhật ký tour', 'mo_dun' => 'nhat_ky_tours', 'mo_ta' => 'Xem nhật ký tour'],
            ['ten' => 'nhat_ky_tours.create', 'ten_hien_thi' => 'Tạo nhật ký tour', 'mo_dun' => 'nhat_ky_tours', 'mo_ta' => 'Tạo nhật ký tour mới'],
            ['ten' => 'nhat_ky_tours.edit', 'ten_hien_thi' => 'Sửa nhật ký tour', 'mo_dun' => 'nhat_ky_tours', 'mo_ta' => 'Chỉnh sửa nhật ký tour'],
            ['ten' => 'nhat_ky_tours.delete', 'ten_hien_thi' => 'Xóa nhật ký tour', 'mo_dun' => 'nhat_ky_tours', 'mo_ta' => 'Xóa nhật ký tour'],

            // Bookings / Đặt tour
            ['ten' => 'bookings.view', 'ten_hien_thi' => 'Xem đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Xem danh sách đặt tour'],
            ['ten' => 'bookings.create', 'ten_hien_thi' => 'Tạo đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Tạo đặt tour mới'],
            ['ten' => 'bookings.edit', 'ten_hien_thi' => 'Sửa đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Chỉnh sửa đặt tour'],
            ['ten' => 'bookings.delete', 'ten_hien_thi' => 'Xóa đặt tour', 'mo_dun' => 'bookings', 'mo_ta' => 'Xóa đặt tour'],

            // Khách hàng đặt tour
            ['ten' => 'customers.view', 'ten_hien_thi' => 'Xem khách hàng', 'mo_dun' => 'customers', 'mo_ta' => 'Xem danh sách khách hàng đặt tour'],
            ['ten' => 'customers.create', 'ten_hien_thi' => 'Tạo khách hàng', 'mo_dun' => 'customers', 'mo_ta' => 'Tạo thông tin khách hàng mới'],
            ['ten' => 'customers.edit', 'ten_hien_thi' => 'Sửa khách hàng', 'mo_dun' => 'customers', 'mo_ta' => 'Chỉnh sửa thông tin khách hàng'],
            ['ten' => 'customers.delete', 'ten_hien_thi' => 'Xóa khách hàng', 'mo_dun' => 'customers', 'mo_ta' => 'Xóa thông tin khách hàng'],

            // Guides
            ['ten' => 'guides.view', 'ten_hien_thi' => 'Xem hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Xem danh sách và chi tiết hướng dẫn viên'],
            ['ten' => 'guides.create', 'ten_hien_thi' => 'Tạo hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Tạo hướng dẫn viên mới'],
            ['ten' => 'guides.edit', 'ten_hien_thi' => 'Sửa hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Chỉnh sửa hướng dẫn viên'],
            ['ten' => 'guides.delete', 'ten_hien_thi' => 'Xóa hướng dẫn viên', 'mo_dun' => 'guides', 'mo_ta' => 'Xóa hướng dẫn viên'],

            // Phương tiện
            ['ten' => 'phuong_tiens.view', 'ten_hien_thi' => 'Xem phương tiện', 'mo_dun' => 'phuong_tiens', 'mo_ta' => 'Xem danh sách phương tiện'],
            ['ten' => 'phuong_tiens.create', 'ten_hien_thi' => 'Tạo phương tiện', 'mo_dun' => 'phuong_tiens', 'mo_ta' => 'Tạo phương tiện mới'],
            ['ten' => 'phuong_tiens.edit', 'ten_hien_thi' => 'Sửa phương tiện', 'mo_dun' => 'phuong_tiens', 'mo_ta' => 'Chỉnh sửa phương tiện'],
            ['ten' => 'phuong_tiens.delete', 'ten_hien_thi' => 'Xóa phương tiện', 'mo_dun' => 'phuong_tiens', 'mo_ta' => 'Xóa phương tiện'],

            // Phân công
            ['ten' => 'phan_cong.view', 'ten_hien_thi' => 'Xem phân công', 'mo_dun' => 'phan_cong', 'mo_ta' => 'Xem danh sách phân công'],
            ['ten' => 'phan_cong.create', 'ten_hien_thi' => 'Tạo phân công', 'mo_dun' => 'phan_cong', 'mo_ta' => 'Tạo phân công mới'],
            ['ten' => 'phan_cong.edit', 'ten_hien_thi' => 'Sửa phân công', 'mo_dun' => 'phan_cong', 'mo_ta' => 'Chỉnh sửa phân công'],
            ['ten' => 'phan_cong.delete', 'ten_hien_thi' => 'Xóa phân công', 'mo_dun' => 'phan_cong', 'mo_ta' => 'Xóa phân công'],

            // Gộp đoàn
            ['ten' => 'gop_doan.view', 'ten_hien_thi' => 'Xem gộp đoàn', 'mo_dun' => 'gop_doan', 'mo_ta' => 'Xem danh sách gộp đoàn'],
            ['ten' => 'gop_doan.create', 'ten_hien_thi' => 'Tạo gộp đoàn', 'mo_dun' => 'gop_doan', 'mo_ta' => 'Tạo yêu cầu gộp đoàn mới'],
            ['ten' => 'gop_doan.edit', 'ten_hien_thi' => 'Sửa gộp đoàn', 'mo_dun' => 'gop_doan', 'mo_ta' => 'Cập nhật yêu cầu gộp đoàn'],
            ['ten' => 'gop_doan.delete', 'ten_hien_thi' => 'Xóa gộp đoàn', 'mo_dun' => 'gop_doan', 'mo_ta' => 'Hủy yêu cầu gộp đoàn'],

            // Banners
            ['ten' => 'banners.view', 'ten_hien_thi' => 'Xem banner', 'mo_dun' => 'banners', 'mo_ta' => 'Xem danh sách banner'],
            ['ten' => 'banners.create', 'ten_hien_thi' => 'Tạo banner', 'mo_dun' => 'banners', 'mo_ta' => 'Tạo banner mới'],
            ['ten' => 'banners.edit', 'ten_hien_thi' => 'Sửa banner', 'mo_dun' => 'banners', 'mo_ta' => 'Chỉnh sửa banner'],
            ['ten' => 'banners.delete', 'ten_hien_thi' => 'Xóa banner', 'mo_dun' => 'banners', 'mo_ta' => 'Xóa banner'],

            // Danh mục
            ['ten' => 'danh_mucs.view', 'ten_hien_thi' => 'Xem danh mục', 'mo_dun' => 'danh_mucs', 'mo_ta' => 'Xem danh sách danh mục'],
            ['ten' => 'danh_mucs.create', 'ten_hien_thi' => 'Tạo danh mục', 'mo_dun' => 'danh_mucs', 'mo_ta' => 'Tạo danh mục mới'],
            ['ten' => 'danh_mucs.edit', 'ten_hien_thi' => 'Sửa danh mục', 'mo_dun' => 'danh_mucs', 'mo_ta' => 'Chỉnh sửa danh mục'],
            ['ten' => 'danh_mucs.delete', 'ten_hien_thi' => 'Xóa danh mục', 'mo_dun' => 'danh_mucs', 'mo_ta' => 'Xóa danh mục'],

            // Đánh giá
            ['ten' => 'reviews.view', 'ten_hien_thi' => 'Xem đánh giá', 'mo_dun' => 'reviews', 'mo_ta' => 'Xem danh sách đánh giá'],
            ['ten' => 'reviews.create', 'ten_hien_thi' => 'Tạo đánh giá', 'mo_dun' => 'reviews', 'mo_ta' => 'Tạo đánh giá mới'],
            ['ten' => 'reviews.edit', 'ten_hien_thi' => 'Sửa đánh giá', 'mo_dun' => 'reviews', 'mo_ta' => 'Chỉnh sửa đánh giá'],
            ['ten' => 'reviews.delete', 'ten_hien_thi' => 'Xóa đánh giá', 'mo_dun' => 'reviews', 'mo_ta' => 'Xóa đánh giá'],

            // Payments
            ['ten' => 'payments.view', 'ten_hien_thi' => 'Xem thanh toán', 'mo_dun' => 'payments', 'mo_ta' => 'Xem danh sách thanh toán'],
            ['ten' => 'payments.create', 'ten_hien_thi' => 'Tạo thanh toán', 'mo_dun' => 'payments', 'mo_ta' => 'Tạo thanh toán mới'],
            ['ten' => 'payments.edit', 'ten_hien_thi' => 'Cập nhật thanh toán', 'mo_dun' => 'payments', 'mo_ta' => 'Cập nhật trạng thái thanh toán'],
            ['ten' => 'payments.delete', 'ten_hien_thi' => 'Xóa thanh toán', 'mo_dun' => 'payments', 'mo_ta' => 'Xóa thanh toán'],

            // Reports
            ['ten' => 'reports.view', 'ten_hien_thi' => 'Xem báo cáo', 'mo_dun' => 'reports', 'mo_ta' => 'Xem báo cáo thống kê'],
            ['ten' => 'reports.export', 'ten_hien_thi' => 'Xuất báo cáo', 'mo_dun' => 'reports', 'mo_ta' => 'Xuất báo cáo thống kê'],

            // Điều khoản
            ['ten' => 'terms.view', 'ten_hien_thi' => 'Xem điều khoản', 'mo_dun' => 'terms', 'mo_ta' => 'Xem trang điều khoản'],
            ['ten' => 'terms.edit', 'ten_hien_thi' => 'Sửa điều khoản', 'mo_dun' => 'terms', 'mo_ta' => 'Chỉnh sửa nội dung điều khoản'],

            // Tour yêu thích
            ['ten' => 'favorites.view', 'ten_hien_thi' => 'Xem tour yêu thích', 'mo_dun' => 'favorites', 'mo_ta' => 'Xem danh sách tour yêu thích'],
            ['ten' => 'favorites.delete', 'ten_hien_thi' => 'Xóa tour yêu thích', 'mo_dun' => 'favorites', 'mo_ta' => 'Xóa tour khỏi danh sách yêu thích'],

            // System access
            ['ten' => 'vao_admin', 'ten_hien_thi' => 'Truy cập Admin', 'mo_dun' => 'system', 'mo_ta' => 'Quyền truy cập khu vực quản trị'],
            ['ten' => 'vao_guide', 'ten_hien_thi' => 'Truy cập Guide', 'mo_dun' => 'system', 'mo_ta' => 'Quyền truy cập khu vực hướng dẫn viên'],

            // Special
            ['ten' => 'manage_users', 'ten_hien_thi' => 'Quản lý người dùng', 'mo_dun' => 'users', 'mo_ta' => 'Cho phép quản lý tài khoản người dùng'],
            ['ten' => 'manage_roles', 'ten_hien_thi' => 'Quản lý vai trò', 'mo_dun' => 'roles', 'mo_ta' => 'Cho phép quản lý vai trò và quyền'],
        ];

        foreach ($permissions as $permission) {
            QuyenHan::updateOrCreate(
                ['ten' => $permission['ten']],
                array_merge($permission, ['trang_thai' => true])
            );
        }
    }
}
