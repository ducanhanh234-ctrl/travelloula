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
        Schema::create('nhat_ky_tour', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained('tour_du_lich')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('nguoi_thao_tac');

            $table->string('hanh_dong');
            $table->text('du_lieu_cu')->nullable();
            $table->text('du_lieu_moi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhat_ky_tour');
    }
};
