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
        Schema::create('khach_hang_dat_tours', function (Blueprint $table) {
    $table->id();
    $table->foreignId('dat_tour_id')->constrained('dat_tours')->cascadeOnDelete();
    $table->string('ho_ten', 255);
    $table->string('gioi_tinh', 10)->nullable();
    $table->integer('nam_sinh')->nullable();
    $table->string('so_dien_thoai', 20)->nullable();
    $table->string('email', 255)->nullable();
    $table->string('so_giay_to', 50)->nullable();
    $table->string('loai_giay_to', 20)->nullable();
    $table->string('loai_hanh_khach', 20)->default('adult');
    $table->string('trang_thai_thanh_toan', 20)->default('pending');
    $table->enum('trang_thai_check_in', ['chua_check_in', 'da_check_in'])->default('chua_check_in');
    $table->timestamp('thoi_gian_check_in')->nullable();
    $table->decimal('so_tien_da_thanh_toan', 12, 2)->default(0);
    $table->decimal('tong_tien', 12, 2)->default(0);
    $table->text('yeu_cau_dac_biet')->nullable();
    $table->string('so_phong', 255)->nullable();
    $table->string('loai_phong', 255)->nullable();
    $table->foreignId('nguoi_cung_phong_id')->nullable()->constrained('khach_hang_dat_tours')->nullOnDelete();
    $table->boolean('da_check_in')->default(false);
    $table->timestamp('thoi_gian_da_check_in')->nullable();
    $table->text('ghi_chu')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_hang_dat_tours');
    }
};
