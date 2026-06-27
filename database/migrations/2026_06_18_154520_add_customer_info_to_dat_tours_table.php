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
            $table->string('ten_nguoi_dat')->nullable();
            $table->string('so_dien_thoai', 20)->nullable();
            $table->string('email')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('dat_tours', function (Blueprint $table) {
            $table->dropColumn([
                'ten_nguoi_dat',
                'so_dien_thoai',
                'email'
            ]);
        });
    }
};
