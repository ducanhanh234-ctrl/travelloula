<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {

            // Đánh dấu lịch đã được gộp hay chưa
            $table->boolean('da_gop')
                ->default(false)
                ->after('huong_dan_vien_id');

            // Lưu ID lịch được gộp vào
            $table->foreignId('gop_vao_lich_id')
                ->nullable()
                ->after('da_gop')
                ->constrained('lich_khoi_hanh_tours')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {

            $table->dropForeign(['gop_vao_lich_id']);

            $table->dropColumn([
                'gop_vao_lich_id',
                'da_gop'
            ]);
        });
    }
};
