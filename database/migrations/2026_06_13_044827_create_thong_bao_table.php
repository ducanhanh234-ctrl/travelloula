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
        Schema::create('thong_bao', function (Blueprint $table) {
            $table->id();

            $table->foreignId('khach_hang_dat_tour_id')
                ->constrained('khach_hang_dat_tours')
                ->cascadeOnDelete();

            $table->string('tieu_de', 255);

            $table->text('noi_dung');

            $table->enum('loai_thong_bao', [
                'dat_tour',
                'thanh_toan',
                'tour',
                'khuyen_mai',
                'he_thong'
            ])->default('he_thong');

            $table->boolean('da_doc')->default(false);

            $table->timestamp('thoi_gian_doc')->nullable();

            $table->string('duong_dan', 500)->nullable();

            $table->json('du_lieu_bo_sung')->nullable();

            $table->timestamp('thoi_gian_gui')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_bao');
    }
};
