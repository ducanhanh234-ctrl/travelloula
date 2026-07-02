<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_lich_trinhs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lich_trinh_tour_id')
                ->constrained('lich_trinh_tours')
                ->cascadeOnDelete();

            $table->time('gio_bat_dau');

            $table->time('gio_ket_thuc')->nullable();

            $table->string('tieu_de');

            $table->text('noi_dung')->nullable();

            $table->integer('thu_tu')->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_lich_trinhs');
    }
};