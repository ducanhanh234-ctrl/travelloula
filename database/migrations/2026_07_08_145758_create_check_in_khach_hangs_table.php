<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_in_khach_hangs', function (Blueprint $table) {
            $table->id();

            // Khách được check-in
            $table->foreignId('khach_hang_dat_tour_id')
                ->constrained('khach_hang_dat_tours')
                ->onDelete('cascade');

            // Lịch khởi hành
            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->onDelete('cascade');

            // Chi tiết lịch trình (Ngày 1 - Hồ Gươm, Ngày 2 - Fansipan...)
            $table->foreignId('chi_tiet_lich_trinh_id')
                ->constrained('chi_tiet_lich_trinhs')
                ->onDelete('cascade');

            // Hướng dẫn viên thực hiện check-in
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');

            $table->dateTime('thoi_gian_check_in')->nullable();

            $table->enum('trang_thai', [
                'chua_check_in',
                'da_check_in'
            ])->default('chua_check_in');

            $table->text('ghi_chu')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_in_khach_hangs');
    }
};
