<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\PhanCongController;
use App\Http\Controllers\PhuongTienController;
use App\Http\Controllers\QuanLyDatTourController;
use App\Http\Controllers\QuyenHanController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TrangDieuKhoanClientController;
use App\Http\Controllers\TrangDieuKhoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaiTroController;

use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\TourClientController;
use App\Http\Controllers\Client\TourYeuThichController;

use App\Http\Controllers\Admin\ChiTietLichTrinhController;
use App\Http\Controllers\Admin\GopDoanController;
use App\Http\Controllers\Admin\LichKhoiHanhController;
use App\Http\Controllers\Admin\LichTrinhTourController;
use App\Http\Controllers\Admin\NhatKyTourController;
use App\Http\Controllers\Admin\TourController;

/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeClientController::class, 'index'])
    ->name('home');

Route::get('/trang_chu', [HomeClientController::class, 'index'])
    ->name('Client.trang_chu.index');

Route::get('/tour', [TourClientController::class, 'index'])
    ->name('Client.danh_sach_tour.index');

Route::get('/tour/{id}', [TourClientController::class, 'show'])
    ->name('Client.danh_sach_tour.show');

Route::get('/bai_viet', function () {
    return view('Client.bai_viet.index');
})->name('Client.bai_viet.index');

Route::get('/bai_viet/{id}', function ($id) {
    return view('Client.bai_viet.detail', compact('id'));
})->name('Client.bai_viet.detail');

Route::get('/ve_chung_toi', function () {
    return view('Client.ve_chung_toi.index');
})->name('Client.ve_chung_toi.index');

Route::get('/dieu_khoan', [TrangDieuKhoanClientController::class, 'index'])
    ->name('Client.dieu_khoan.index');

Route::get('/demo', function () {
    return view('Client.demo');
})->name('Client.demo');

/*
|--------------------------------------------------------------------------
| TOUR YÊU THÍCH
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/tour_yeu_thich', [TourYeuThichController::class, 'index'])
        ->name('Client.tour_yeu_thich.index');

    Route::post('/tour_yeu_thich/{tourId}', [TourYeuThichController::class, 'store'])
        ->name('Client.tour_yeu_thich.store');

    Route::delete('/tour_yeu_thich/{tourId}', [TourYeuThichController::class, 'destroy'])
        ->name('Client.tour_yeu_thich.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.perform');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.perform');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('Admin')
    ->name('Admin.')
    ->middleware(['auth', 'permission:vao_admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/', function () {
            return view('layouts.admin');
        })->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | USER / ROLE / PERMISSION
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class);

        Route::resource('vai-tros', VaiTroController::class);

        Route::resource('quyen-hans', QuyenHanController::class);

        Route::get('role-permissions/matrix', [RolePermissionController::class, 'matrix'])
            ->name('role-permissions.matrix');

        Route::post('role-permissions/update-matrix', [RolePermissionController::class, 'updateMatrix'])
            ->name('role-permissions.update-matrix');

        /*
        |--------------------------------------------------------------------------
        | KHÁCH HÀNG / HƯỚNG DẪN VIÊN
        |--------------------------------------------------------------------------
        */

        Route::resource('khach-hang', KhachHangDatTourController::class);

        Route::resource('huong-dan-viens', HuongDanVienController::class);

        /*
        |--------------------------------------------------------------------------
        | TRANG ĐIỀU KHOẢN
        |--------------------------------------------------------------------------
        */

        Route::get('/trang_dieu_khoans/edit', [TrangDieuKhoanController::class, 'edit'])
            ->name('trang_dieu_khoans.edit');

        Route::put('/trang_dieu_khoans', [TrangDieuKhoanController::class, 'update'])
            ->name('trang_dieu_khoans.update');

        /*
        |--------------------------------------------------------------------------
        | QUẢN LÝ ĐẶT TOUR
        |--------------------------------------------------------------------------
        */

        Route::get('/quan-ly-dat-tour', [QuanLyDatTourController::class, 'index'])
            ->name('quan_ly_dat_tour.index');

        Route::get('/dat-tours/create', [QuanLyDatTourController::class, 'create'])
            ->name('dat_tours.create');

        Route::post('/dat-tours', [QuanLyDatTourController::class, 'store'])
            ->name('dat_tours.store');

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

        Route::put('/quan-ly-dat-tour/{id}/update-status', [QuanLyDatTourController::class, 'updateStatus'])
            ->name('dat_tours.update-status');

        Route::get('/tour/{tourId}/lich-khoi-hanh', [QuanLyDatTourController::class, 'getLichKhoiHanhByTour'])
            ->name('dat_tours.lich-khoi-hanh');

        /*
        |--------------------------------------------------------------------------
        | THANH TOÁN
        |--------------------------------------------------------------------------
        */

        Route::prefix('thanh_toans')->name('thanh_toans.')->group(function () {
            Route::get('/', [ThanhToanController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [ThanhToanController::class, 'show'])
                ->name('show');

            Route::get('/{id}/edit_status', [ThanhToanController::class, 'editStatus'])
                ->name('edit_status');

            Route::put('/{id}', [ThanhToanController::class, 'updateStatus'])
                ->name('update_status');

            Route::delete('/{id}', [ThanhToanController::class, 'destroy'])
                ->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | ĐÁNH GIÁ
        |--------------------------------------------------------------------------
        */

        Route::prefix('danh_gias')->name('danh_gias.')->group(function () {
            Route::get('/', [DanhGiaController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [DanhGiaController::class, 'show'])
                ->name('show');

            Route::delete('/{id}', [DanhGiaController::class, 'destroy'])
                ->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | THỐNG KÊ
        |--------------------------------------------------------------------------
        */

        Route::prefix('thong_ke')->name('thong_ke.')->group(function () {
            Route::get('/', [ThongKeController::class, 'index'])
                ->name('index');

            Route::get('/export', [ThongKeController::class, 'export'])
                ->name('export');
        });

        /*
        |--------------------------------------------------------------------------
        | BANNER / DANH MỤC / PHƯƠNG TIỆN
        |--------------------------------------------------------------------------
        */

        Route::resource('banners', BannerController::class);

        Route::resource('danh_mucs', DanhMucController::class);

        Route::resource('phuong-tiens', PhuongTienController::class);

        /*
        |--------------------------------------------------------------------------
        | TOUR
        |--------------------------------------------------------------------------
        */

        Route::resource('tours', TourController::class);

        Route::resource('lich-khoi-hanh', LichKhoiHanhController::class);

        Route::resource('gop-doan', GopDoanController::class);

        Route::post('gop-doan/{id}/huy', [GopDoanController::class, 'destroy'])
            ->name('gop-doan.huy');

        Route::post('gop-doan/chi-tiet/{id}/trang-thai', [GopDoanController::class, 'capNhatTrangThaiLienHe'])
            ->name('gop-doan.cap-nhat-trang-thai');

        Route::post('gop-doan/{id}/chot', [GopDoanController::class, 'chotGop'])
            ->name('gop-doan.chot');

        /*
        |--------------------------------------------------------------------------
        | LỊCH TRÌNH TOUR
        |--------------------------------------------------------------------------
        */

        Route::resource('lich_trinh_tours', LichTrinhTourController::class);

        Route::get('tour/{tour}/lich-trinh', [LichTrinhTourController::class, 'indexByTour'])
            ->name('lich_trinh_tours.tour');

        Route::prefix('lich_trinh_tours/{lichTrinh}/chi_tiet')
            ->name('chi_tiet_lich_trinhs.')
            ->group(function () {
                Route::get('/', [ChiTietLichTrinhController::class, 'index'])
                    ->name('index');

                Route::get('/create', [ChiTietLichTrinhController::class, 'create'])
                    ->name('create');

                Route::post('/', [ChiTietLichTrinhController::class, 'store'])
                    ->name('store');
            });

        Route::get('chi_tiet_lich_trinhs/{chiTiet}/edit', [ChiTietLichTrinhController::class, 'edit'])
            ->name('chi_tiet_lich_trinhs.edit');

        Route::put('chi_tiet_lich_trinhs/{chiTiet}', [ChiTietLichTrinhController::class, 'update'])
            ->name('chi_tiet_lich_trinhs.update');

        Route::delete('chi_tiet_lich_trinhs/{chiTiet}', [ChiTietLichTrinhController::class, 'destroy'])
            ->name('chi_tiet_lich_trinhs.destroy');

        /*
        |--------------------------------------------------------------------------
        | NHẬT KÝ TOUR
        |--------------------------------------------------------------------------
        */

        Route::resource('nhat_ky_tours', NhatKyTourController::class)
            ->only(['index', 'show']);

        /*
        |--------------------------------------------------------------------------
        | PHÂN CÔNG
        |--------------------------------------------------------------------------
        */

        Route::resource('phan-cong', PhanCongController::class);
    });

/*
|--------------------------------------------------------------------------
| GUIDE ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('Guide')
    ->name('Guide.')
    ->middleware(['auth', 'permission:vao_guide'])
    ->group(function () {

        Route::get('/', function () {
            return view('layouts.guide');
        })->name('dashboard');

        Route::resource('phuong-tiens', PhuongTienController::class);
    });
