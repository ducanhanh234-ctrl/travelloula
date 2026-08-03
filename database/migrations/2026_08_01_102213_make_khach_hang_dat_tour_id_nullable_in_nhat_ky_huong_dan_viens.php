<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nhat_ky_huong_dan_viens', function (Blueprint $table) {
            $table->foreignId('khach_hang_dat_tour_id')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('nhat_ky_huong_dan_viens', function (Blueprint $table) {
            $table->foreignId('khach_hang_dat_tour_id')
                ->nullable(false)
                ->change();
        });
    }
};
