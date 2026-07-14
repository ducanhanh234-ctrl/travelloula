<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bai_viets', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->string('duong_dan')->unique();
            $table->string('anh_dai_dien')->nullable();
            $table->text('mo_ta_ngan')->nullable();
            $table->longText('noi_dung')->nullable();
            $table->string('tac_gia')->nullable();
            $table->unsignedInteger('luot_xem')->default(0);
            $table->tinyInteger('trang_thai')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bai_viets');
    }
};