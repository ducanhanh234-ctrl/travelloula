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
         Schema::create('tour_du_lich', function (Blueprint $table) {
            $table->id();
            $table->string('ten_tour');
            $table->string('slug')->unique();
            $table->string('anh_dai_dien')->nullable();
            $table->decimal('gia_tour', 12, 2);
            $table->string('thoi_gian');
            $table->string('dia_diem_khoi_hanh');
            $table->string('dia_diem_den');
            $table->integer('so_luong_toi_da');
            $table->text('mo_ta')->nullable();
            $table->text('dich_vu_bao_gom')->nullable();
            $table->text('dich_vu_khong_bao_gom')->nullable();
            $table->string('trang_thai')->default('hoat_dong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_du_lich');
    }
};
