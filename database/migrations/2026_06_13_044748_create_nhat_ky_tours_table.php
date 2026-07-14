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
        if (!Schema::hasTable('nhat_ky_tours')) {
            Schema::create('nhat_ky_tours', function (Blueprint $table) {
                $table->id();

                $table->foreignId('tour_id')
                    ->constrained('danh_sach_tours')
                    ->cascadeOnDelete();

                $table->foreignId('nguoi_dung_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->string('hanh_dong', 255);
                $table->text('du_lieu_cu')->nullable();
                $table->text('du_lieu_moi')->nullable();
                $table->string('dia_chi_ip', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhat_ky_tours');
    }
};