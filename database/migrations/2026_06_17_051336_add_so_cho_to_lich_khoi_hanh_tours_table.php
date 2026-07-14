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
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->integer('so_cho')->default(0)->after('gia_tre_em');
        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->dropColumn('so_cho');
        });
    }
};
