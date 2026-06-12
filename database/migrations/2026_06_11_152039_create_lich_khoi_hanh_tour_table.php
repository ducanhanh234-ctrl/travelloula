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
        Schema::create('lich_khoi_hanh_tour', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained('tour_du_lich')
                ->cascadeOnDelete();

            $table->date('ngay_khoi_hanh');
            $table->date('ngay_ket_thuc');

            $table->integer('so_cho_toi_da');
            $table->integer('so_cho_con_lai');

            $table->string('trang_thai')->default('dang_mo_ban');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_khoi_hanh_tour');
    }
};
