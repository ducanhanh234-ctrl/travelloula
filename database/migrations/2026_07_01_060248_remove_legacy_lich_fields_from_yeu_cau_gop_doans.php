<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // không làm gì cả vì DB đã không còn cột
    }

    public function down(): void
    {
        Schema::table('yeu_cau_gop_doans', function (Blueprint $table) {

            $table->foreignId('lich_nguon_id')
                ->nullable()
                ->constrained('lich_khoi_hanh_tours');

            $table->foreignId('lich_dich_id')
                ->nullable()
                ->constrained('lich_khoi_hanh_tours');
        });
    }
};
