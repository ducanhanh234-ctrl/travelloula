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
        Schema::create('khuyen_mais', function (Blueprint $table) {
            $table->id();
            $table->string('ma_khuyen_mai', 50)->unique();
            $table->text('mo_ta')->nullable();
            $table->decimal('phan_tram_giam', 5, 2)->nullable();
            $table->decimal('so_tien_giam', 12, 2)->nullable();
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->string('trang_thai', 20)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khuyen_mais');
    }
};
