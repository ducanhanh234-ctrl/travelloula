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
        Schema::create('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('danh_sach_tours')->cascadeOnDelete();
            $table->date('ngay_khoi_hanh');
            $table->date('ngay_ket_thuc')->nullable();
            $table->integer('so_cho_con_lai')->default(0);
            $table->integer('so_cho_da_dat')->default(0);
            $table->foreignId('huong_dan_vien_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('trang_thai', 20)->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_khoi_hanh_tours');
    }
};
