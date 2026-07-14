<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->integer('gia_nguoi_lon')->default(0);
            $table->integer('gia_tre_em')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->dropColumn(['gia_nguoi_lon', 'gia_tre_em']);
        });
    }
};
