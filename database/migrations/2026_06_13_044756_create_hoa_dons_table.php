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
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dat_tour_id')->constrained('dat_tours')->cascadeOnDelete();
            $table->foreignId('thanh_toan_id')->nullable()->constrained('thanh_toans')->nullOnDelete();
            $table->string('ma_hoa_don', 100)->unique();
            $table->decimal('tong_tien', 12, 2);
            $table->decimal('thue', 12, 2)->default(0);
            $table->decimal('tong_thanh_toan', 12, 2);
            $table->date('ngay_xuat_hoa_don')->nullable();
            $table->string('trang_thai', 20)->default('da_tao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_dons');
    }
};
