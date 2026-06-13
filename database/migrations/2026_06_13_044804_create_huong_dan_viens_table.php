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
        Schema::create('huong_dan_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 255);
            $table->string('email', 255)->unique();
            $table->string('so_dien_thoai', 20)->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->enum('gioi_tinh', ['nam', 'nu', 'khac'])->nullable();
            $table->text('dia_chi')->nullable();
            $table->string('anh_dai_dien', 255)->nullable();
            $table->integer('so_nam_kinh_nghiem')->default(0);
            $table->text('mo_ta')->nullable();
            $table->enum('trang_thai', ['hoat_dong', 'khong_hoat_dong', 'bi_khoa'])->default('hoat_dong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('huong_dan_viens');
    }
};
