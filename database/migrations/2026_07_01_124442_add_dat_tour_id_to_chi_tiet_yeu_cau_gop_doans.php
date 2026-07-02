<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table(
            'chi_tiet_yeu_cau_gop_doans',
            function (Blueprint $table) {

                $table->foreignId('dat_tour_id')
                    ->nullable()
                    ->after('lich_khoi_hanh_id');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chi_tiet_yeu_cau_gop_doans', function (Blueprint $table) {
            //
        });
    }
};
