<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {

            $table->boolean('dang_gop_doan')
                ->default(0)
                ->after('da_gop')
                ->comment('0: chưa gộp, 1: đang trong quy trình gộp đoàn');
        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->dropColumn('dang_gop_doan');
        });
    }
};
