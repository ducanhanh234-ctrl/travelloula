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
        Schema::create('theo_doi_yeu_cau_khachs', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('khach_tour_id');

            $table->enum('loai_yeu_cau', [
                'an_uong',
                'y_te',
                'dac_biet',
                'luu_tru'
            ]);

            $table->text('chi_tiet_yeu_cau');

            $table->enum('muc_do_uu_tien', [
                'thap',
                'trung_binh',
                'cao',
                'khan_cap'
            ])->default('trung_binh');

            $table->enum('trang_thai', [
                'cho_xu_ly',
                'da_tiep_nhan',
                'dang_xu_ly',
                'hoan_thanh'
            ])->default('cho_xu_ly');

            $table->unsignedBigInteger('phan_cong_cho')
                ->nullable();

            $table->text('ghi_chu')
                ->nullable();

            $table->timestamp('thoi_gian_tiep_nhan')
                ->nullable();

            $table->timestamp('thoi_gian_hoan_thanh')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theo_doi_yeu_cau_khachs');
    }
};
