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
        Schema::create('lich_trinh_huong_dan_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');
            $table->unsignedBigInteger('tour_id');
            $table->dateTime('ngay_bat_dau');
            $table->dateTime('ngay_ket_thuc');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_trinh_huong_dan_viens');
    }
};
