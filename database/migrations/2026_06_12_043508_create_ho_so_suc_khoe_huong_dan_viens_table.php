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
        Schema::create('ho_so_suc_khoe_huong_dan_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');
            $table->string('nhom_mau', 10)->nullable();
            $table->text('tinh_trang_suc_khoe')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ho_so_suc_khoe_huong_dan_viens');
    }
};
