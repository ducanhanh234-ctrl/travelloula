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
        Schema::create('danh_gia', function (Blueprint $table) {
            $table->id();

            $table->foreignId('khach_hang_dat_tour_id')
                ->constrained('khach_hang_dat_tours')
                ->cascadeOnDelete();

            $table->foreignId('tour_id')
                ->constrained('danh_sach_tours')
                ->cascadeOnDelete();

            $table->tinyInteger('so_sao');

            $table->string('tieu_de', 255)->nullable();

            $table->text('noi_dung_danh_gia')->nullable();

            $table->boolean('hien_thi')->default(true);

            $table->timestamp('thoi_gian_danh_gia')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gia');
    }
};
