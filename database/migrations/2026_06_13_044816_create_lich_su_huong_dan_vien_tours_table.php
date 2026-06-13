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
        Schema::create('lich_su_huong_dan_vien_tours', function (Blueprint $table) {
    $table->id();

    $table->foreignId('ma_huong_dan_vien')
        ->constrained('huong_dan_viens')
        ->cascadeOnDelete();

    $table->foreignId('ma_tour')
        ->constrained('danh_sach_tours')
        ->cascadeOnDelete();

    $table->date('ngay_bat_dau_tour');
    $table->date('ngay_ket_thuc_tour');
    $table->tinyInteger('danh_gia')->nullable();
    $table->text('phan_hoi')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_huong_dan_vien_tours');
    }
};
