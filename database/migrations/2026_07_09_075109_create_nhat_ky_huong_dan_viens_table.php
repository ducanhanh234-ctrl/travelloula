<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nhat_ky_huong_dan_viens', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            $table->foreignId('chi_tiet_lich_trinh_id')
                ->constrained('chi_tiet_lich_trinhs')
                ->cascadeOnDelete();

            $table->foreignId('khach_hang_dat_tour_id')
                ->constrained('khach_hang_dat_tours')
                ->cascadeOnDelete();

            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->cascadeOnDelete();

            $table->string('hanh_dong');

            $table->text('noi_dung');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nhat_ky_huong_dan_viens');
    }
};
