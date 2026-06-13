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
        Schema::create('tro_chuyens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dat_tour_id');
            $table->timestamps();
            //khóa ngoại
            $table->foreign('dat_tour_id')
                ->references('id')
                ->on('dat_tours')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tro_chuyens');
    }
};
