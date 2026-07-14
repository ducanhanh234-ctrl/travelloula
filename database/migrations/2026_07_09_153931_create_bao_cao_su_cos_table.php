<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bao_cao_su_cos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->cascadeOnDelete();

            $table->string('tieu_de');

            $table->enum('loai_su_co', [
                'khach_hang',
                'phuong_tien',
                'thoi_tiet',
                'lich_trinh',
                'khac'
            ]);

            $table->enum('muc_do', [
                'thap',
                'trung_binh',
                'cao'
            ]);

            $table->text('noi_dung');

            $table->enum('trang_thai', [
                'cho_xu_ly',
                'dang_xu_ly',
                'da_xu_ly'
            ])->default('cho_xu_ly');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bao_cao_su_cos');
    }
};
