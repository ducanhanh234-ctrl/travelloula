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
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ma_chuyen_khoi_hanh')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            $table->foreignId('ma_hanh_khach')
                ->constrained('khach_tours')
                ->cascadeOnDelete();

            $table->foreignId('ma_dat_tour')
                ->constrained('dat_tours')
                ->cascadeOnDelete();

            $table->foreignId('nguoi_diem_danh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamp('thoi_gian_check_in')->nullable();
            $table->string('dia_diem_check_in')->nullable();

            $table->enum('trang_thai', [
                'chua_diem_danh',
                'da_diem_danh',
                'vang_mat'
            ])->default('chua_diem_danh');

            $table->text('ghi_chu')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
