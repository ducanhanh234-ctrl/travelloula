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
        Schema::create('khach_tours', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('tour_dieu_hanh_id');

            $table->unsignedBigInteger('dat_tour_id')
                ->nullable();

            $table->string('ho_ten');

            $table->string('so_dien_thoai')
                ->nullable();

            $table->string('email')
                ->nullable();

            $table->date('ngay_sinh')
                ->nullable();

            $table->enum('gioi_tinh', [
                'nam',
                'nu',
                'khac'
            ])->nullable();

            $table->text('yeu_cau_an_uong')
                ->nullable();

            $table->text('tinh_trang_suc_khoe')
                ->nullable();

            $table->text('yeu_cau_dac_biet')
                ->nullable();

            $table->text('ghi_chu')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_tours');
    }
};
