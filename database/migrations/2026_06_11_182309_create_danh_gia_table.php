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
        Schema::create('danh_gia', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('tour_id');

            $table->unsignedBigInteger('booking_id')
                ->nullable();

            $table->unsignedBigInteger('danh_gia_cha_id')
                ->nullable();

            $table->unsignedBigInteger('user_id');

            $table->integer('diem_danh_gia')
                ->nullable();

            $table->text('noi_dung')
                ->nullable();

            $table->text('hinh_anh')
                ->nullable();

            $table->string('trang_thai', 20)
                ->default('hien_thi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gia');
    }
};
