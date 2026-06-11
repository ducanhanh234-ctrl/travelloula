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
        Schema::create('tin_nhan_tro_chuyens', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('tro_chuyen_id');
            $table->unsignedBigInteger('nguoi_gui_id');

            $table->text('noi_dung_tin_nhan');

            $table->timestamp('thoi_gian_gui')->useCurrent();

            // Khóa ngoại
            $table->foreign('tro_chuyen_id')
                ->references('id')
                ->on('tro_chuyens')
                ->onDelete('cascade');

            $table->foreign('nguoi_gui_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tin_nhan_tro_chuyens');
    }
};
