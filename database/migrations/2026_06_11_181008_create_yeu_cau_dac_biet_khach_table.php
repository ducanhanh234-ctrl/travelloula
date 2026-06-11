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
        Schema::create('yeu_cau_dac_biet_khach', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('dat_tour_id');

            $table->unsignedBigInteger('lich_khoi_hanh_id');

            $table->enum('loai_yeu_cau', [
                'an_uong',
                'y_te',
                'ho_tro_di_chuyen',
                'khac'
            ])->default('khac');

            $table->string('tieu_de');

            $table->text('mo_ta');

            $table->enum('trang_thai', [
                'cho_xu_ly',
                'da_tiep_nhan',
                'da_hoan_thanh',
                'da_huy'
            ])->default('cho_xu_ly');

            $table->text('ghi_chu')
                ->nullable();

            $table->unsignedBigInteger('cap_nhat_boi')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_dac_biet_khach');
    }
};
