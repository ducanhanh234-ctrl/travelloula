<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lich_trinh_tour', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained('tour_du_lich')
                ->cascadeOnDelete();

            $table->integer('ngay_thu');
            $table->string('tieu_de');
            $table->string('dia_diem')->nullable();
            $table->text('hoat_dong')->nullable();
            $table->string('bua_an')->nullable();
            $table->string('khach_san')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_trinh_tour');
    }
};
