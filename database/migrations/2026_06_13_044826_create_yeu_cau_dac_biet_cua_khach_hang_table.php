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
        Schema::create('yeu_cau_dac_biet_cua_khach_hang', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dat_tour_id')
                ->constrained('dat_tours')
                ->cascadeOnDelete();

            $table->foreignId('khach_hang_id')
                ->nullable()
                ->constrained('khach_hang_dat_tours')
                ->nullOnDelete();

            $table->string('loai_yeu_cau', 100);

            $table->text('noi_dung_yeu_cau');

            $table->enum('muc_do_uu_tien', [
                'thap',
                'trung_binh',
                'cao',
                'khan_cap'
            ])->default('trung_binh');

            $table->enum('trang_thai', [
                'cho_xu_ly',
                'dang_xu_ly',
                'da_xu_ly',
                'tu_choi'
            ])->default('cho_xu_ly');

            $table->text('ghi_chu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_dac_biet_cua_khach_hang');
    }
};
