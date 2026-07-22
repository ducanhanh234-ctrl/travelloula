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
        Schema::create('diem_danh_khach_hangs', function (Blueprint $table) {
            $table->id();

            // Khách
            $table->foreignId('khach_hang_dat_tour_id')
                ->constrained('khach_hang_dat_tours')
                ->onDelete('cascade');

            // Lịch khởi hành
            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->onDelete('cascade');

            // Hướng dẫn viên điểm danh
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');

            // Ngày điểm danh (mỗi ngày chỉ điểm danh 1 lần)
            $table->unsignedTinyInteger('ngay_thu');
            $table->date('ngay_diem_danh');
            $table->enum('trang_thai', [
                'chua_diem_danh',
                'co_mat',
                'vang_mat',
            ])->default('chua_diem_danh');
            $table->dateTime('thoi_gian_diem_danh')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diem_danh_khach_hangs');
    }
};
