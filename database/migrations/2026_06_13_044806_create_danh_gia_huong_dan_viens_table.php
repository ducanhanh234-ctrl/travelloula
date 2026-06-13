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
         Schema::create('danh_gia_huong_dan_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');
            $table->unsignedBigInteger('khach_hang_id');
            $table->tinyInteger('so_sao')->unsigned()->default(5);
            $table->text('noi_dung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gia_huong_dan_viens');
    }
};
