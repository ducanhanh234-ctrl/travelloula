<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('huong_dan_viens', function (Blueprint $table) {
            DB::statement("
            ALTER TABLE huong_dan_viens
            MODIFY trang_thai
            ENUM(
                'san_sang',
                'dang_dan_tour',
                'tam_ngung',
                'nghi_viec',
                'hoat_dong',
                'khong_hoat_dong',
                'bi_khoa'
            )
            NOT NULL
            DEFAULT 'san_sang'
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('huong_dan_viens', function (Blueprint $table) {
            DB::statement("
            ALTER TABLE huong_dan_viens
            MODIFY trang_thai
            ENUM(
                'san_sang',
                'dang_dan_tour',
                'tam_ngung',
                'nghi_viec',
                'hoat_dong',
                'khong_hoat_dong',
                'bi_khoa'
            )
            NOT NULL
            DEFAULT 'san_sang'
        ");
        });
    }
};
