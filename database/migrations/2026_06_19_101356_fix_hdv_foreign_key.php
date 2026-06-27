<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {

            $table->dropForeign([
                'huong_dan_vien_id'
            ]);

            $table->foreign('huong_dan_vien_id')
                ->references('id')
                ->on('huong_dan_viens')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {

            $table->dropForeign([
                'huong_dan_vien_id'
            ]);

            $table->foreign('huong_dan_vien_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};
