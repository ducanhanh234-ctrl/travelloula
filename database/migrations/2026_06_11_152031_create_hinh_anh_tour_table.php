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
        Schema::create('hinh_anh_tour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')
                ->constrained('tour_du_lich')
                ->cascadeOnDelete();

            $table->string('duong_dan_anh');
            $table->integer('thu_tu')->default(0);
            $table->boolean('anh_dai_dien')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hinh_anh_tour');
    }
};
