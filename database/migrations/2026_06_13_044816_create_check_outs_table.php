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
        Schema::create('check_outs', function (Blueprint $table) {
    $table->id();

    $table->foreignId('ma_nguoi_dung')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->foreignId('ma_dat_tour')
        ->constrained('dat_tours')
        ->cascadeOnDelete();

    $table->enum('loai_diem_danh', [
        'check_in',
        'check_out'
    ])->default('check_out');

    $table->timestamp('thoi_gian_diem_danh')->nullable();
    $table->string('dia_diem', 255)->nullable();
    $table->decimal('vi_do', 10, 8)->nullable();
    $table->decimal('kinh_do', 11, 8)->nullable();
    $table->text('ghi_chu')->nullable();
    $table->string('trang_thai_xac_nhan', 255)->default('cho_xac_nhan');
    $table->string('nguoi_xac_minh', 255)->nullable();
    $table->timestamp('thoi_gian_xac_minh')->nullable();
    $table->json('du_lieu_bo_sung')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_outs');
    }
};
