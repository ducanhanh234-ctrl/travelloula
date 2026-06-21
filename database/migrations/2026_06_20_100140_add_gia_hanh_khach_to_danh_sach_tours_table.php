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
        Schema::table('danh_sach_tours', function (Blueprint $table) {

            $table->decimal('gia_nguoi_lon', 15, 0)->default(0);

            $table->decimal('gia_tre_em', 15, 0)->default(0);

            $table->decimal('gia_em_be', 15, 0)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('danh_sach_tours', function (Blueprint $table) {

            $table->dropColumn([
                'gia_nguoi_lon',
                'gia_tre_em',
                'gia_em_be'
            ]);
        });
    }
};
