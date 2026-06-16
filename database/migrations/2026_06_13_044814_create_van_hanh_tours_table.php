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
        Schema::create('van_hanh_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lich_khoi_hanh_id')->constrained('lich_khoi_hanh_tours')->cascadeOnDelete();
            $table->foreignId('phuong_tien_id')->nullable()->constrained('phuong_tiens')->nullOnDelete();
            $table->string('nguoi_dieu_hanh', 255)->nullable();
            $table->string('lien_he_khan_cap', 20)->nullable();
            $table->dateTime('thoi_gian_khoi_hanh')->nullable();
            $table->string('diem_tap_trung', 255)->nullable();
            $table->text('ghi_chu_van_hanh')->nullable();
            $table->string('trang_thai', 20)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('van_hanh_tours');
    }
};
