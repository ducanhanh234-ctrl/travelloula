<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_saves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lich_khoi_hanh_id');
            $table->unsignedBigInteger('chi_tiet_lich_trinh_id')->nullable();
            $table->unsignedBigInteger('huong_dan_vien_id')->nullable();
            $table->string('action')->default('CONFIRM_CHI_TIET');
            $table->timestamps();

            $table->index(['lich_khoi_hanh_id']);
            $table->index(['chi_tiet_lich_trinh_id']);
            $table->unique(['lich_khoi_hanh_id', 'chi_tiet_lich_trinh_id', 'action'], 'uniq_checkin_save');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_saves');
    }
};
