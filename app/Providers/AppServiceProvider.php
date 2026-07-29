<?php

namespace App\Providers;

use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\CheckRole;
use App\Models\LienHe;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Route::aliasMiddleware('role', CheckRole::class);
        Route::aliasMiddleware('permission', CheckPermission::class);
        // Chia sẻ biến $countChuaDoc cho tất cả view hoặc view layout/sidebar cụ thể
        View::composer('*', function ($view) {
            $countChuaDoc = LienHe::where('trang_thai', 'Chưa đọc')->count();
            $view->with('countChuaDoc', $countChuaDoc);
        });
    }
}
