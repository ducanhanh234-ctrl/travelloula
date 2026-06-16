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
        Schema::create('dat_tours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nguoi_dung_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('tour_id')
                ->constrained('danh_sach_tours')
                ->cascadeOnDelete();

            $table->foreignId('lich_khoi_hanh_id')
                ->nullable()
                ->constrained('lich_khoi_hanh_tours')
                ->nullOnDelete();

            $table->foreignId('khuyen_mai_id')
                ->nullable()
                ->constrained('khuyen_mais')
                ->nullOnDelete();

            $table->string('ma_dat_tour', 50)->unique();

            $table->integer('so_nguoi_lon')->default(1);
            $table->integer('so_tre_em')->default(0);
            $table->integer('so_em_be')->default(0);

            $table->decimal('tong_tien', 12, 2);
            $table->decimal('so_tien_da_thanh_toan', 12, 2)->default(0);

            $table->enum('trang_thai', [
                'cho_xac_nhan',
                'da_xac_nhan',
                'da_thanh_toan',
                'da_huy',
                'hoan_thanh'
            ])->default('cho_xac_nhan');

            $table->text('ghi_chu')->nullable();

            $table->timestamp('ngay_dat')->useCurrent();

            $table->index('trang_thai');
            $table->index('ngay_dat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dat_tours');
    }
};
