<?php


use App\Http\Controllers\DanhGiaController;

use App\Http\Controllers\ThongKeController;



use App\Http\Controllers\BannerController;

use App\Http\Controllers\DanhMucController;


use App\Http\Controllers\ThanhToanController;



use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\QuyenHanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaiTroController;
use App\Http\Controllers\QuanLyDatTourController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\NgayKhoiHanhTourController;
use App\Http\Controllers\Admin\LichTrinhTourController;
use App\Http\Controllers\Admin\HinhAnhTourController;

use App\Http\Controllers\Admin\DatTourController;
use App\Http\Controllers\Admin\NhatKyTourController;




// use App\Http\Controllers\TourController;
// Client routes

Route::get('/', function () {
    return view('Client.trang_chu.index');
})->name('client.home');


Route::get('/bai_viet', function () {
    return view('Client.bai_viet.index');
});
Route::get('/{id}/bai_viet', function () {

    return view('Client.bai_viet.detail');

})->name('bai_viet.detail');







Route::get('/demo', function () {
    return view('Client.demo');
});
Route::get('/trang_chu', function () {
    return view('Client.trang_chu.index');
});
Route::get('/ve_chung_toi', function () {
    return view('Client.ve_chung_toi.index');
});


Route::get('/danh_sach_tour_yeu_thich', function () {
    return view('Client.danh_sach_tour_yeu_thich.index');
});
Route::get('/dieu_khoan', function () {
    return view('Client.dieu_khoan.index');
});
Route::get('/{id}/dat_tour', [QuanLyDatTourController::class,'create_dat_tour'])->name('create_dat_tour');
Route::post('/dat_tour',[QuanLyDatTourController::class,'store_dat_tour'])->name('store_dat_tour');
// Auth routes
use App\Http\Controllers\AuthController;

use App\Http\Controllers\PhuongTienController;


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Login ADMIN
Route::prefix('Admin')->name('Admin.')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/', function () {
        return view('Layouts.admin');
    })->name('dashboard');
    // Admin routes
    Route::resource('users', UserController::class);
    // Route::resource('vai-tros', VaiTroController::class);
    // Route::resource('quyen-hans', QuyenHanController::class);
    Route::resource('khach-hang', KhachHangDatTourController::class);
    Route::resource('huong-dan-viens', HuongDanVienController::class);
    Route::get('/quan-ly-dat-tour', [QuanLyDatTourController::class, 'index'])->name('quan_ly_dat_tour.index');
    // thêm booking thủ công

    Route::get('/dat-tours/create', [QuanLyDatTourController::class, 'create'])
        ->name('dat-tours.create');

    Route::get('/dat-tours/{id}', [QuanLyDatTourController::class, 'show'])
        ->name('dat_tours.show');

        //sửa
    Route::get('/dat-tours/{id}/edit', [QuanLyDatTourController::class, 'edit'])
        ->name('dat_tours.edit');

    Route::put('/dat-tours/{id}', [QuanLyDatTourController::class, 'update'])
        ->name('dat_tours.update');

    //xóa mềm
    Route::delete(
        '/quan-ly-dat-tour/{id}',
        [QuanLyDatTourController::class, 'destroy']
    )->name('dat_tours.destroy');

    // xóa cứng
    Route::delete(
        '/quan-ly-dat-tour/{id}/force-delete',
        [QuanLyDatTourController::class, 'forceDelete']
    )->name('dat_tours.forceDelete');

    // khôi phục
    Route::post(
        '/dat-tours/{id}/restore',
        [QuanLyDatTourController::class, 'restore']
    )->name('dat_tours.restore');

    //thùng rác
    Route::get(
        '/dat-tours-trash',
        [QuanLyDatTourController::class, 'trash']
    )->name('dat_tours.trash');

    Route::post(
        '/dat-tours',
        [QuanLyDatTourController::class, 'store']
    )
        ->name('dat-tours.store');

    //lich khởi hành theo tour
    Route::get(
        '/tour/{tourId}/lich-khoi-hanh',
        [QuanLyDatTourController::class, 'getLichKhoiHanhByTour']
    )->name('dat-tours.lich-khoi-hanh');

    Route::put('/quan-ly-dat-tour/{id}/update-status', [QuanLyDatTourController::class, 'updateStatus'])->name('dat_tours.update-status');

    Route::prefix('/thanh_toans')->name('thanh_toans.')->group(function () {
        Route::get('/', [ThanhToanController::class, 'index'])->name('index');
        Route::get('/{id}', [ThanhToanController::class, 'show'])->name('show');
        Route::get('/{id}/edit_status', [ThanhToanController::class, 'editStatus'])->name('edit_status');
        Route::put('/{id}', [ThanhToanController::class, 'updateStatus'])->name('update_status');
        Route::delete('/{id}', [ThanhToanController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/danh_gias')->name('danh_gias.')->group(function () {
        Route::get('/', [DanhGiaController::class, 'index'])->name('index');
        Route::get('/{id}', [DanhGiaController::class, 'show'])->name('show');
        Route::delete('/{id}', [DanhGiaController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/thong_ke')->name('thong_ke.')->group(function () {
        Route::get('/', [ThongKeController::class, 'index'])->name('index');
        Route::get('/export', [ThongKeController::class, 'export'])->name('export');
    });
    Route::resource(
        'banners',
        BannerController::class
    );
    Route::resource(
        'danh_mucs',
        DanhMucController::class
    );
    Route::resource('phuong-tiens', PhuongTienController::class);


    Route::resource('tours', TourController::class);

    Route::resource(
        'lich_trinh_tours',
        LichTrinhTourController::class
    );

    Route::resource(
        'nhat_ky_tours',
        NhatKyTourController::class
    )->only([
        'index',
        'show'
    ]);
});















// Route::prefix('guide')->name('guide.')->middleware(['auth', \App\Http\Middleware\IsGuide::class])->group(function () {


// });


// Login Guide
Route::prefix('Guide')->name('Guide.')->middleware(['auth', \App\Http\Middleware\IsGuide::class])->group(function () {


    Route::get('/', function () {
        return view('Layouts.guide');
    })->name('dashboard');
    //Guide routes
    Route::resource('phuong-tiens', PhuongTienController::class);
});
Route::get('/vnpay/payment/{id}', [ThanhToanController::class, 'createPayment'])
    ->name('vnpay.payment');

Route::get('/vnpay/return', [ThanhToanController::class, 'vnpayReturn'])
    ->name('vnpay.return');