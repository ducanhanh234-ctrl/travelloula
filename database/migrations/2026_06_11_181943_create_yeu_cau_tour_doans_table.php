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
        Schema::create('yeu_cau_tour_doans', function (Blueprint $table) {

            $table->id();

            $table->string('ho_ten');

            $table->string('email');

            $table->string('so_dien_thoai');

            $table->string('to_chuc')
                ->nullable();

            $table->string('diem_den');

            $table->date('ngay_khoi_hanh');

            $table->string('thoi_luong')
                ->nullable();

            $table->integer('nguoi_lon')
                ->default(1);

            $table->integer('tre_em')
                ->default(0);

            $table->integer('em_be')
                ->default(0);

            $table->string('ngan_sach')
                ->nullable();

            $table->json('dich_vu')
                ->nullable();

            $table->text('ghi_chu')
                ->nullable();

            $table->string('trang_thai')
                ->default('cho_xu_ly');

            $table->text('ghi_chu_quan_tri')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_tour_doans');
    }
};
