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
        Schema::create('thanh_toans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dat_tour_id')->constrained('dat_tours')->cascadeOnDelete();
            $table->foreignId('nguoi_dung_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('phuong_thuc_thanh_toan', 100);
            $table->decimal('so_tien', 12, 2);
            $table->string('ma_giao_dich', 100)->nullable();
            $table->string('trang_thai', 20)->default('cho_thanh_toan');
            $table->text('ghi_chu')->nullable();
            $table->timestamp('thoi_gian_thanh_toan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};
