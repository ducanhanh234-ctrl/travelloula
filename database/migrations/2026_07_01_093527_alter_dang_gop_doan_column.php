<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->tinyInteger('dang_gop_doan')
                ->default(0)
                ->comment('0: chưa tạo yêu cầu, 1: đã tạo, 2: CSKH, 3: hoàn tất')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->tinyInteger('dang_gop_doan')->default(0)->change();
        });
    }
};
