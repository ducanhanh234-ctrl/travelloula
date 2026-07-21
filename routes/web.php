<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\GuideProfileController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\PhanCongController;
use App\Http\Controllers\PhuongTienController;
use App\Http\Controllers\QuanLyDatTourController;
use App\Http\Controllers\QuyenHanController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TourDaDatController;
use App\Http\Controllers\TrangDieuKhoanClientController;
use App\Http\Controllers\TrangDieuKhoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaiTroController;
use App\Http\Controllers\Admin\ChiTietLichTrinhController;
use App\Http\Controllers\Admin\GopDoanController;
use App\Http\Controllers\Admin\LichKhoiHanhController;
use App\Http\Controllers\Admin\LichTrinhTourController;
use App\Http\Controllers\Admin\NhatKyTourController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Client\BaiVietClientController;
use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\TourClientController;
use App\Http\Controllers\Client\TourYeuThichController;
use App\Http\Controllers\Guide\BaoCaoSuCoController;
use App\Http\Controllers\Guide\CheckInController;
use App\Http\Controllers\Guide\GuideController;
use App\Http\Controllers\Guide\NhatKyHuongDanVienController;

/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeClientController::class, 'index'])->name('home');
Route::get('/trang_chu', [HomeClientController::class, 'index'])->name('Client.trang_chu.index');

Route::get('/tour', [TourClientController::class, 'index'])->name('Client.danh_sach_tour.index');
Route::get('/tour/{id}', [TourClientController::class, 'show'])->name('Client.danh_sach_tour.show');

Route::get('/bai_viet', [BaiVietClientController::class, 'index'])->name('Client.bai_viet.index');
Route::get('/bai_viet/{duongDan}', [BaiVietClientController::class, 'show'])->name('Client.bai_viet.detail');

Route::view('/ve_chung_toi', 'Client.ve_chung_toi.index')->name('Client.ve_chung_toi.index');
Route::get('/dieu_khoan', [TrangDieuKhoanClientController::class, 'index'])->name('Client.dieu_khoan.index');
Route::view('/demo', 'Client.demo')->name('Client.demo');

Route::get('/{id}/dat_tour', [QuanLyDatTourController::class, 'create_dat_tour'])->name('create_dat_tour');
Route::post('/dat_tour', [QuanLyDatTourController::class, 'store_dat_tour'])->name('store_dat_tour');

Route::resource('tour_da_dat', TourDaDatController::class);

Route::get('/vnpay/payment/{id}', [ThanhToanController::class, 'createPayment'])->name('vnpay.payment');
Route::get('/vnpay/return', [ThanhToanController::class, 'vnpayReturn'])->name('vnpay.return');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/tour_yeu_thich', [TourYeuThichController::class, 'index'])->name('Client.tour_yeu_thich.index');
    Route::post('/tour_yeu_thich/{tourId}', [TourYeuThichController::class, 'store'])->name('Client.tour_yeu_thich.store');
    Route::delete('/tour_yeu_thich/{tourId}', [TourYeuThichController::class, 'destroy'])->name('Client.tour_yeu_thich.destroy');

    // Khách hàng gửi đánh giá tour.
    Route::post('/tour/{tour}/danh-gia', [DanhGiaController::class, 'store'])
        ->name('Client.danh_gia.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('Admin')
    ->name('Admin.')
    ->middleware(['auth', 'permission:vao_admin'])
    ->group(function () {
        Route::view('/', 'layouts.admin')->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('vai-tros', VaiTroController::class);
        Route::resource('quyen-hans', QuyenHanController::class);

        Route::get('role-permissions/matrix', [RolePermissionController::class, 'matrix'])
            ->name('role-permissions.matrix');
        Route::post('role-permissions/update-matrix', [RolePermissionController::class, 'updateMatrix'])
            ->name('role-permissions.update-matrix');

        Route::resource('khach-hang', KhachHangDatTourController::class);
        Route::resource('huong-dan-viens', HuongDanVienController::class);
        Route::resource('bai_viets', BaiVietController::class);

        Route::get('/trang_dieu_khoans/edit', [TrangDieuKhoanController::class, 'edit'])
            ->name('trang_dieu_khoans.edit');
        Route::put('/trang_dieu_khoans', [TrangDieuKhoanController::class, 'update'])
            ->name('trang_dieu_khoans.update');

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

        Route::prefix('thanh_toans')->name('thanh_toans.')->group(function () {
            Route::get('/', [ThanhToanController::class, 'index'])->name('index');
            Route::get('/{id}', [ThanhToanController::class, 'show'])->name('show');
            Route::get('/{id}/edit_status', [ThanhToanController::class, 'editStatus'])->name('edit_status');
            Route::put('/{id}', [ThanhToanController::class, 'updateStatus'])->name('update_status');
            Route::delete('/{id}', [ThanhToanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('danh_gias')->name('danh_gias.')->group(function () {
            Route::get('/', [DanhGiaController::class, 'index'])->name('index');

            Route::patch('/{id}/approve', [DanhGiaController::class, 'approve'])
                ->name('approve');

            Route::patch('/{id}/hide', [DanhGiaController::class, 'hide'])
                ->name('hide');

            Route::get('/{id}', [DanhGiaController::class, 'show'])->name('show');
            Route::delete('/{id}', [DanhGiaController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('thong_ke')->name('thong_ke.')->group(function () {
            Route::get('/', [ThongKeController::class, 'index'])->name('index');
            Route::get('/export', [ThongKeController::class, 'export'])->name('export');
        });

        Route::resource('banners', BannerController::class);
        Route::resource('danh_mucs', DanhMucController::class);
        Route::resource('phuong-tiens', PhuongTienController::class);
        Route::resource('phan-cong', PhanCongController::class);

        Route::resource('tours', TourController::class);
        Route::resource('lich-khoi-hanh', LichKhoiHanhController::class);

        Route::resource('gop-doan', GopDoanController::class);
        Route::post('gop-doan/{id}/huy', [GopDoanController::class, 'destroy'])->name('gop-doan.huy');
        Route::post('gop-doan/chi-tiet/{id}/trang-thai', [GopDoanController::class, 'capNhatTrangThaiLienHe'])
            ->name('gop-doan.cap-nhat-trang-thai');
        Route::post('gop-doan/{id}/chot', [GopDoanController::class, 'chotGop'])->name('gop-doan.chot');

        Route::resource('lich_trinh_tours', LichTrinhTourController::class);
        Route::get('tour/{tour}/lich-trinh', [LichTrinhTourController::class, 'indexByTour'])
            ->name('lich_trinh_tours.tour');

        Route::prefix('lich_trinh_tours/{lichTrinh}/chi_tiet')
            ->name('chi_tiet_lich_trinhs.')
            ->group(function () {
                Route::get('/', [ChiTietLichTrinhController::class, 'index'])->name('index');
                Route::get('/create', [ChiTietLichTrinhController::class, 'create'])->name('create');
                Route::post('/', [ChiTietLichTrinhController::class, 'store'])->name('store');
            });

        Route::get('chi_tiet_lich_trinhs/{chiTiet}/edit', [ChiTietLichTrinhController::class, 'edit'])
            ->name('chi_tiet_lich_trinhs.edit');
        Route::put('chi_tiet_lich_trinhs/{chiTiet}', [ChiTietLichTrinhController::class, 'update'])
            ->name('chi_tiet_lich_trinhs.update');
        Route::delete('chi_tiet_lich_trinhs/{chiTiet}', [ChiTietLichTrinhController::class, 'destroy'])
            ->name('chi_tiet_lich_trinhs.destroy');

        Route::resource('nhat_ky_tours', NhatKyTourController::class)->only(['index', 'show']);
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
        Route::view('/', 'layouts.guide')->name('dashboard');

        Route::get('/profile', [GuideProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [GuideProfileController::class, 'update'])->name('profile.update');

        Route::resource('phuong-tiens', PhuongTienController::class);
        Route::resource('tour-phan-cong', GuideController::class);
        Route::get('/lich-trinh/{phanCongId}', [GuideController::class, 'lichtrinh'])->name('lich-trinh');
        Route::get('/danh-sach-khach/{phanCongId}', [GuideController::class, 'khachhangdattour'])
            ->name('danh-sach-khach');

        Route::get('/check-in', [CheckInController::class, 'index'])->name('checkin.index');
        Route::get('/check-in/{lichKhoiHanh}/dia-diem', [CheckInController::class, 'diaDiem'])
            ->name('checkin.dia-diem');
        Route::get('/check-in/{lichKhoiHanh}/{chiTiet}', [CheckInController::class, 'show'])
            ->name('checkin.show');
        Route::post('/check-in', [CheckInController::class, 'checkIn'])->name('checkin.store');
        Route::patch('/check-out/{id}', [CheckInController::class, 'checkOut'])->name('checkout');
        Route::post('/check-in/checkin-tat-ca', [CheckInController::class, 'checkInTatCa'])
            ->name('checkin.checkinTatCa');
        Route::post('/check-in/checkout-tat-ca', [CheckInController::class, 'checkOutTatCa'])
            ->name('checkin.checkoutTatCa');
        Route::post('/check-in/{id}/undo', [CheckInController::class, 'undoCheckIn'])->name('checkin.undo');
        Route::post('/check-out/{id}/undo', [CheckInController::class, 'undoCheckOut'])->name('checkout.undo');
        Route::post('/check-in/ghi-chu', [CheckInController::class, 'saveNote'])->name('checkin.note');

        Route::get('/nhat-ky', [NhatKyHuongDanVienController::class, 'index'])->name('nhatky.index');
        Route::get('/nhat-ky/{id}', [NhatKyHuongDanVienController::class, 'show'])->name('nhatky.show');

        Route::get('/bao-cao-su-co', [BaoCaoSuCoController::class, 'index'])->name('baocaosuco.index');
        Route::get('/bao-cao-su-co/create', [BaoCaoSuCoController::class, 'create'])->name('baocaosuco.create');
        Route::post('/bao-cao-su-co', [BaoCaoSuCoController::class, 'store'])->name('baocaosuco.store');
        Route::get('/bao-cao-su-co/trash', [BaoCaoSuCoController::class, 'trash'])->name('baocaosuco.trash');
        Route::patch('/bao-cao-su-co/{id}/restore', [BaoCaoSuCoController::class, 'restore'])
            ->name('baocaosuco.restore');
        Route::delete('/bao-cao-su-co/{id}/force-delete', [BaoCaoSuCoController::class, 'forceDelete'])
            ->name('baocaosuco.forceDelete');
        Route::get('/bao-cao-su-co/{id}/edit', [BaoCaoSuCoController::class, 'edit'])->name('baocaosuco.edit');
        Route::put('/bao-cao-su-co/{id}', [BaoCaoSuCoController::class, 'update'])->name('baocaosuco.update');
        Route::delete('/bao-cao-su-co/{id}', [BaoCaoSuCoController::class, 'destroy'])->name('baocaosuco.destroy');
        Route::get('/bao-cao-su-co/{id}', [BaoCaoSuCoController::class, 'show'])->name('baocaosuco.show');
    });