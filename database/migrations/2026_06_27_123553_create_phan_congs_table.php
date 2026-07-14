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
        Schema::create('phan_congs', function (Blueprint $table) {
            $table->id();


            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            $table->foreignId('hdv_id')
                ->constrained('huong_dan_viens')
                ->cascadeOnDelete();

            $table->foreignId('phuong_tien_id')
                ->constrained('phuong_tiens')
                ->cascadeOnDelete();

            $table->dateTime('ngay_phan_cong')->nullable();

            $table->string('ghi_chu')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_congs');
    }
};
