<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thay_doi_lich_trinhs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            $table->foreignId('chi_tiet_lich_trinh_id')
                ->constrained('chi_tiet_lich_trinhs')
                ->cascadeOnDelete();

            $table->foreignId('huong_dan_vien_id')
                ->nullable()
                ->constrained('huong_dan_viens')
                ->nullOnDelete();

            // thay_the | doi_gio | huy
            $table->string('loai_thay_doi', 30);

            $table->string('tieu_de_moi')->nullable();
            $table->time('gio_bat_dau_moi')->nullable();
            $table->time('gio_ket_thuc_moi')->nullable();

            $table->text('ly_do');
            $table->timestamps();

            $table->unique(
                ['lich_khoi_hanh_id', 'chi_tiet_lich_trinh_id'],
                'tdlt_lich_chitiet_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thay_doi_lich_trinhs');
    }
};
