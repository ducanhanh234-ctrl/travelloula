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
        Schema::create('danh_sach_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danh_muc_id')->constrained('danh_mucs')->cascadeOnDelete();
            $table->string('ten_tour', 255);
            $table->string('duong_dan', 255)->unique();
            $table->string('anh_dai_dien', 255)->nullable();
            $table->decimal('gia_tour', 12, 2);
            $table->string('thoi_luong', 100)->nullable();
            $table->string('dia_diem_khoi_hanh', 255)->nullable();
            $table->string('diem_den', 255)->nullable();
            $table->integer('so_khach_toi_da')->default(0);
            $table->string('phuong_tien', 255)->nullable();
            $table->string('tieu_chuan_khach_san', 255)->nullable();
            $table->text('mo_ta')->nullable();
            $table->text('tong_quan_lich_trinh')->nullable();
            $table->text('dich_vu_bao_gom')->nullable();
            $table->text('dich_vu_khong_bao_gom')->nullable();
            $table->string('trang_thai', 20)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_sach_tours');
    }
};
