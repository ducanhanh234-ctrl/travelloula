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
        Schema::create('diem_danh_huong_dan_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');
            $table->date('ngay_diem_danh');
            $table->time('gio_check_in')->nullable();
            $table->time('gio_check_out')->nullable();
            $table->enum('trang_thai', ['co_mat', 'vang_mat', 'di_muon', 've_som'])->default('co_mat');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diem_danh_huong_dan_viens');
    }
};
