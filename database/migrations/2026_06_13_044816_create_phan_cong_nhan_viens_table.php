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
        Schema::create('phan_cong_nhan_viens', function (Blueprint $table) {
    $table->id();

    $table->foreignId('ma_van_hanh_tour')
        ->constrained('van_hanh_tours')
        ->cascadeOnDelete();

    $table->foreignId('ma_huong_dan_vien')
        ->nullable()
        ->constrained('huong_dan_viens')
        ->nullOnDelete();

    $table->foreignId('ma_nguoi_dung')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->string('ten_nhan_su_ben_ngoai', 255)->nullable();
    $table->string('vai_tro', 255);

    $table->enum('loai_phan_cong', [
        'noi_bo',
        'ben_ngoai'
    ])->default('noi_bo');

    $table->enum('trang_thai', [
        'cho_xac_nhan',
        'da_thong_bao',
        'da_xac_nhan',
        'tu_choi'
    ])->default('cho_xac_nhan');

    $table->timestamp('thoi_gian_xac_nhan')->nullable();
    $table->timestamp('thoi_gian_tu_choi')->nullable();
    $table->text('ghi_chu')->nullable();
    $table->json('du_lieu_bo_sung')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_cong_nhan_viens');
    }
};
