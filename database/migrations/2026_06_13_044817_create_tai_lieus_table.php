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
        Schema::create('tai_lieus', function (Blueprint $table) {
    $table->id();

    $table->foreignId('ma_dat_tour')
        ->constrained('dat_tours')
        ->cascadeOnDelete();

    $table->string('duong_dan_tap_tin', 1024);
    $table->string('loai_tap_tin', 100)->nullable();
    $table->timestamp('thoi_gian_tai_len')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_lieus');
    }
};
