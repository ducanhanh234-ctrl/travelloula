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
        Schema::create('bang_gia_tours', function (Blueprint $table) {

            $table->id();

            $table->foreignId('tour_id')
                ->constrained('danh_sach_tours')
                ->cascadeOnDelete();

            $table->string('ten_bang_gia');

            $table->date('ngay_bat_dau');

            $table->date('ngay_ket_thuc');

            $table->integer('phan_tram_tang')->default(0);

            $table->decimal('gia_nguoi_lon', 15, 0);

            $table->decimal('gia_tre_em', 15, 0);

            $table->enum('trang_thai', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bang_gia_tours');
    }
};