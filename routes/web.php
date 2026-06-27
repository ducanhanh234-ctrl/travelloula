<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\PhuongTienController;
use App\Http\Controllers\QuanLyDatTourController;
use App\Http\Controllers\QuyenHanController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaiTroController;
use App\Http\Controllers\TrangDieuKhoanController;
use App\Http\Controllers\TrangDieuKhoanClientController;

use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\NgayKhoiHanhTourController;
use App\Http\Controllers\Admin\LichTrinhTourController;
use App\Http\Controllers\Admin\HinhAnhTourController;
use App\Http\Controllers\Admin\DatTourController;
use App\Http\Controllers\Admin\NhatKyTourController;


// =======================
// CLIENT ROUTES
// =======================

Route::get('/', function () {
    return view('Client.trang_chu.index');
});

Route::get('/trang_chu', function () {
    return view('Client.trang_chu.index');
});

Route::get('/bai_viet', function () {
    return view('Client.bai_viet.index');
});

Route::get('/{id}/bai_viet', function () {
    return view('Client.bai_viet.detail');
})->name('bai_viet.detail');

Route::get('/demo', function () {
    return view('Client.demo');
});

Route::get('/ve_chung_toi', function () {
    return view('Client.ve_chung_toi.index');
});

Route::get('/danh_sach_tour_yeu_thich', function () {
    return view('Client.danh_sach_tour_yeu_thich.index');
});

Route::get('/dieu_khoan', [TrangDieuKhoanClientController::class, 'index'])
    ->name('Client.dieu_khoan.index');


// =======================
// AUTH ROUTES
// =======================

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =======================
// ADMIN ROUTES
// =======================

Route::prefix('Admin')
    ->name('Admin.')
    ->middleware(['auth', 'permission:vao_admin'])
    ->group(function () {

        Route::get('/', function () {
            return view('layouts.admin');
        })->name('dashboard');

        // Quản lý người dùng / vai trò / quyền
        Route::resource('users', UserController::class);
        Route::resource('vai-tros', VaiTroController::class);
        Route::resource('quyen-hans', QuyenHanController::class);

        Route::get('role-permissions/matrix', [RolePermissionController::class, 'matrix'])
            ->name('role-permissions.matrix');

        Route::post('role-permissions/update-matrix', [RolePermissionController::class, 'updateMatrix'])
            ->name('role-permissions.update-matrix');

        // Quản lý khách hàng / hướng dẫn viên
        Route::resource('khach-hang', KhachHangDatTourController::class);
        Route::resource('huong-dan-viens', HuongDanVienController::class);

        // Quản lý đặt tour
        Route::get('/quan-ly-dat-tour', [QuanLyDatTourController::class, 'index'])
            ->name('quan_ly_dat_tour.index');

        Route::get('/dat-tours/create', [QuanLyDatTourController::class, 'create'])
            ->name('dat-tours.create');

        Route::post('/dat-tours', [QuanLyDatTourController::class, 'store'])
            ->name('dat-tours.store');

        Route::get('/dat-tours/{id}', [QuanLyDatTourController::class, 'show'])
            ->name('dat_tours.show');

        Route::get('/dat-tours/{id}/edit', [QuanLyDatTourController::class, 'edit'])
            ->name('dat_tours.edit');

        Route::put('/dat-tours/{id}', [QuanLyDatTourController::class, 'update'])
            ->name('dat_tours.update');

        Route::delete('/quan-ly-dat-tour/{id}', [QuanLyDatTourController::class, 'destroy'])
            ->name('dat_tours.destroy');

        Route::delete('/quan-ly-dat-tour/{id}/force-delete', [QuanLyDatTourController::class, 'forceDelete'])
            ->name('dat_tours.forceDelete');

        Route::post('/dat-tours/{id}/restore', [QuanLyDatTourController::class, 'restore'])
            ->name('dat_tours.restore');

        Route::get('/dat-tours-trash', [QuanLyDatTourController::class, 'trash'])
            ->name('dat_tours.trash');

        Route::get('/tour/{tourId}/lich-khoi-hanh', [QuanLyDatTourController::class, 'getLichKhoiHanhByTour'])
            ->name('dat-tours.lich-khoi-hanh');

        Route::put('/quan-ly-dat-tour/{id}/update-status', [QuanLyDatTourController::class, 'updateStatus'])
            ->name('dat_tours.update-status');

        // Thanh toán
        Route::prefix('thanh_toans')->name('thanh_toans.')->group(function () {
            Route::get('/', [ThanhToanController::class, 'index'])->name('index');
            Route::get('/{id}', [ThanhToanController::class, 'show'])->name('show');
            Route::get('/{id}/edit_status', [ThanhToanController::class, 'editStatus'])->name('edit_status');
            Route::put('/{id}', [ThanhToanController::class, 'updateStatus'])->name('update_status');
            Route::delete('/{id}', [ThanhToanController::class, 'destroy'])->name('destroy');
        });

        // Đánh giá
        Route::prefix('danh_gias')->name('danh_gias.')->group(function () {
            Route::get('/', [DanhGiaController::class, 'index'])->name('index');
            Route::get('/{id}', [DanhGiaController::class, 'show'])->name('show');
            Route::delete('/{id}', [DanhGiaController::class, 'destroy'])->name('destroy');
        });

        // Thống kê
        Route::prefix('thong_ke')->name('thong_ke.')->group(function () {
            Route::get('/', [ThongKeController::class, 'index'])->name('index');
            Route::get('/export', [ThongKeController::class, 'export'])->name('export');
        });

        // Banner / danh mục / phương tiện / tour
        Route::resource('banners', BannerController::class);
        Route::resource('danh_mucs', DanhMucController::class);
        Route::resource('phuong-tiens', PhuongTienController::class);
        Route::resource('tours', TourController::class);

        Route::resource('lich_trinh_tours', LichTrinhTourController::class);

        Route::resource('nhat_ky_tours', NhatKyTourController::class)->only([
            'index',
            'show'
        ]);

        // Trang điều khoản
        Route::get('/trang_dieu_khoans/edit', [TrangDieuKhoanClientController::class, 'edit'])
            ->name('trang_dieu_khoans.edit');

        Route::put('/trang_dieu_khoans', [TrangDieuKhoanController::class, 'update'])
            ->name('trang_dieu_khoans.update');
    });


// =======================
// GUIDE ROUTES
// =======================

Route::prefix('Guide')
    ->name('Guide.')
    ->middleware(['auth', 'permission:vao_guide'])
    ->group(function () {

        Route::get('/', function () {
            return view('layouts.guide');
        })->name('dashboard');

        Route::resource('phuong-tiens', PhuongTienController::class);
    });
