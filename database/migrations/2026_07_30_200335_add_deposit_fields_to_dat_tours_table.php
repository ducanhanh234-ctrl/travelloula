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
        Schema::table('dat_tours', function (Blueprint $table) {
            // Khách chọn thanh toán bao nhiêu %
            $table->unsignedTinyInteger('phan_tram_thanh_toan')
                ->default(100)
                ->after('tong_tien');

            // Số tiền còn phải thanh toán
            $table->decimal('so_tien_con_lai', 15, 2)
                ->default(0)
                ->after('phan_tram_thanh_toan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dat_tours', function (Blueprint $table) {
            $table->dropColumn([
                'phan_tram_thanh_toan',
                'so_tien_con_lai',
            ]);
        });
    }
};
