<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_yeu_cau_gop_doans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('yeu_cau_gop_doan_id')
                ->constrained('yeu_cau_gop_doans')
                ->cascadeOnDelete();

            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            // Lịch giữ lại sau khi gộp?
            $table->boolean('la_lich_chinh')
                ->default(false);

            // CSKH đã liên hệ chưa
            $table->enum('trang_thai_lien_he', [
                'chua_lien_he',
                'dong_y',
                'tu_choi'
            ])->default('chua_lien_he');

            $table->text('ghi_chu')
                ->nullable();

            $table->timestamp('thoi_gian_lien_he')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_yeu_cau_gop_doans');
    }
};
