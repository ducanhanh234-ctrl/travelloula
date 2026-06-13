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
        Schema::create('canh_bao_van_hanh_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('van_hanh_tour_id')->constrained('van_hanh_tours')->cascadeOnDelete();
            $table->string('loai_canh_bao', 100);
            $table->text('noi_dung');
            $table->string('muc_do', 20)->default('medium');
            $table->boolean('da_xu_ly')->default(false);
            $table->foreignId('nguoi_xu_ly_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('thoi_gian_xu_ly')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canh_bao_van_hanh_tours');
    }
};
