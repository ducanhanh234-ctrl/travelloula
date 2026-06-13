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
        Schema::create('lich_ranh_huong_dan_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');
            $table->date('ngay_ranh');
            $table->enum('ca_lam_viec', ['sang', 'chieu', 'toi', 'ca_ngay'])->default('ca_ngay');
            $table->enum('trang_thai', ['ranh', 'ban'])->default('ranh');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_ranh_huong_dan_viens');
    }
};
