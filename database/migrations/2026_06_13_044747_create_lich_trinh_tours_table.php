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
        Schema::create('lich_trinh_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('danh_sach_tours')->cascadeOnDelete();
            $table->integer('ngay_thu');
            $table->string('tieu_de', 255);
            $table->string('dia_diem', 255)->nullable();
            $table->text('hoat_dong')->nullable();
            $table->string('bua_an', 255)->nullable();
            $table->string('thong_tin_khach_san', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_trinh_tours');
    }
};
