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
        Schema::create('van_hanh_tour', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tour')
                ->cascadeOnDelete();

            $table->string('phuong_tien');
            $table->string('nguoi_dieu_hanh');
            $table->string('so_dien_thoai_khan_cap');

            $table->dateTime('gio_khoi_hanh');
            $table->string('dia_diem_tap_trung');

            $table->text('ghi_chu')->nullable();

            $table->string('trang_thai')->default('binh_thuong');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('van_hanh_tour');
    }
};
