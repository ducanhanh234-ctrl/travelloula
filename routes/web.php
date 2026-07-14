<?php

use App\Http\Controllers\Admin\ChiTietLichTrinhController;
use App\Http\Controllers\Admin\DatTourController;
use App\Http\Controllers\Admin\GopDoanController;
use App\Http\Controllers\Admin\HinhAnhTourController;
use App\Http\Controllers\Admin\LichKhoiHanhController;
use App\Http\Controllers\Admin\LichTrinhTourController;
use App\Http\Controllers\Admin\NgayKhoiHanhTourController;
use App\Http\Controllers\Admin\NhatKyTourController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\Client\HomeClientController;
use App\Http\Controllers\Client\TourClientController;
use App\Http\Controllers\Client\TourYeuThichController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\Guide\BaoCaoSuCoController;
use App\Http\Controllers\Guide\CheckInController;
use App\Http\Controllers\Guide\NhatKyHuongDanVienController;
use App\Http\Controllers\HuongDanVienController;
use App\Http\Controllers\KhachHangDatTourController;
use App\Http\Controllers\PhanCongController;
use App\Http\Controllers\PhuongTienController;
use App\Http\Controllers\QuanLyDatTourController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaiTroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('Admin')
    ->name('Admin.')
    ->middleware([
        'auth',
        \App\Http\Middleware\IsAdmin::class
    ])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', function () {
            return view('Layouts.admin');
        })->name('dashboard');



        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'users',
            UserController::class
        );



        /*
        |--------------------------------------------------------------------------
        | KHÁCH HÀNG
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'khach-hang',
            KhachHangDatTourController::class
        );



        /*
        |--------------------------------------------------------------------------
        | HƯỚNG DẪN VIÊN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'huong-dan-viens',
            HuongDanVienController::class
        );



        /*
        |--------------------------------------------------------------------------
        | LỊCH KHỞI HÀNH
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'lich-khoi-hanh',
            LichKhoiHanhController::class
        );



        /*
        |--------------------------------------------------------------------------
        | GỘP ĐOÀN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'gop-doan',
            GopDoanController::class
        );


        // Hủy yêu cầu gộp đoàn
        Route::post(
            'gop-doan/{id}/huy',
            [
                GopDoanController::class,
                'destroy'
            ]
        )->name('gop-doan.huy');

        Route::post(
            'gop-doan/chi-tiet/{id}/trang-thai',
            [
                GopDoanController::class,
                'capNhatTrangThaiLienHe'
            ]
        )
            ->name('gop-doan.cap-nhat-trang-thai');

        Route::post(
            'gop-doan/{id}/chot',
            [
                GopDoanController::class,
                'chotGop'
            ]
        )->name('gop-doan.chot');
    });



/*
|--------------------------------------------------------------------------
| GUIDE ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('Guide')
    ->name('Guide.')
    ->middleware(['auth', \App\Http\Middleware\IsGuide::class])
    ->group(function () {

        Route::get('/', function () {
            return view('Layouts.guide');
        })->name('dashboard');
    });




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
    Route::resource('phan-cong', PhanCongController::class);

    Route::resource('tours', TourController::class);

    Route::resource(
        'lich_trinh_tours',
        LichTrinhTourController::class
    );
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

    Route::get(
        'chi_tiet_lich_trinhs/{chiTiet}/edit',
        [ChiTietLichTrinhController::class, 'edit']
    )->name('chi_tiet_lich_trinhs.edit');

    Route::put(
        'chi_tiet_lich_trinhs/{chiTiet}',
        [ChiTietLichTrinhController::class, 'update']
    )->name('chi_tiet_lich_trinhs.update');

    Route::delete(
        'chi_tiet_lich_trinhs/{chiTiet}',
        [ChiTietLichTrinhController::class, 'destroy']
    )->name('chi_tiet_lich_trinhs.destroy');
    Route::get(
        'tour/{tour}/lich-trinh',
        [LichTrinhTourController::class, 'indexByTour']
    )->name('lich_trinh_tours.tour');

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

    // Check-in
    Route::get('/check-in', [CheckInController::class, 'index'])
        ->name('checkin.index');

    Route::get(
        '/check-in/{lichKhoiHanh}/dia-diem',
        [CheckInController::class, 'diaDiem']
    )->name('checkin.dia-diem');

    Route::get('/check-in/{lichKhoiHanh}/{chiTiet}', [CheckInController::class, 'show'])
        ->name('checkin.show');

    Route::post('/check-in', [CheckInController::class, 'checkIn'])
        ->name('checkin.store');

    Route::patch('/check-out/{id}',[CheckInController::class, 'checkOut'])
    ->name('checkout');

    Route::post('/check-in/checkin-tat-ca', [CheckInController::class, 'checkInTatCa'])
        ->name('checkin.checkinTatCa');

    Route::post('/check-in/checkout-tat-ca', [CheckInController::class, 'checkOutTatCa'])
        ->name('checkin.checkoutTatCa');

    Route::post('/check-in/{id}/undo',[CheckInController::class, 'undoCheckIn'])
    ->name('checkin.undo');

    Route::post('/check-out/{id}/undo',[CheckInController::class, 'undoCheckOut'])
    ->name('checkout.undo');

    Route::post('/check-in/ghi-chu',[CheckInController::class, 'saveNote'])
    ->name('checkin.note');

    // Nhật ký
    Route::get('/nhat-ky', [NhatKyHuongDanVienController::class, 'index'])
        ->name('nhatky.index');

    Route::get('/nhat-ky/{id}', [NhatKyHuongDanVienController::class, 'show'])
        ->name('nhatky.show');

    // Báo cáo sự cố
    Route::get('/bao-cao-su-co', [BaoCaoSuCoController::class, 'index'])
        ->name('baocaosuco.index');

    Route::get('/bao-cao-su-co/create', [BaoCaoSuCoController::class, 'create'])
        ->name('baocaosuco.create');

    Route::post('/bao-cao-su-co', [BaoCaoSuCoController::class, 'store'])
        ->name('baocaosuco.store');

    Route::patch('/check-out/{id}', [CheckInController::class, 'checkOut'])
        ->name('checkout');

    Route::get('/bao-cao-su-co/trash', [BaoCaoSuCoController::class, 'trash'])
        ->name('baocaosuco.trash');

    Route::patch('/bao-cao-su-co/{id}/restore', [BaoCaoSuCoController::class, 'restore'])
        ->name('baocaosuco.restore');

    Route::delete('/bao-cao-su-co/{id}/force-delete', [BaoCaoSuCoController::class, 'forceDelete'])
        ->name('baocaosuco.forceDelete');

    Route::get('/bao-cao-su-co/{id}/edit', [BaoCaoSuCoController::class, 'edit'])
        ->name('baocaosuco.edit');

    Route::put('/bao-cao-su-co/{id}', [BaoCaoSuCoController::class, 'update'])
        ->name('baocaosuco.update');

    Route::delete('/bao-cao-su-co/{id}', [BaoCaoSuCoController::class, 'destroy'])
        ->name('baocaosuco.destroy');

    Route::get('/bao-cao-su-co/{id}', [BaoCaoSuCoController::class, 'show'])
        ->name('baocaosuco.show');
});
