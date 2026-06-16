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
        Schema::create('huong_dan_vien_danh_mucs', function (Blueprint $table) {
            $table->foreignId('huong_dan_vien_id')
                  ->constrained('huong_dan_viens')
                  ->onDelete('cascade');
            $table->foreignId('danh_muc_id')
                  ->constrained('danh_muc_huong_dan_viens')
                  ->onDelete('cascade');
            $table->primary(['huong_dan_vien_id', 'danh_muc_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('huong_dan_vien_danh_mucs');
    }
};
