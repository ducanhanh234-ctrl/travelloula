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
         Schema::create('trang_dieu_khoans', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->string('duong_dan')->unique();
            $table->longText('noi_dung')->nullable();
            $table->tinyInteger('trang_thai')->default(1);
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trang_dieu_khoans');
    }
};
