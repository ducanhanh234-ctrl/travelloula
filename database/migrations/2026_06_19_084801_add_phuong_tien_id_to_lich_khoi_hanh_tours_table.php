<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {

            $table->foreignId('phuong_tien_id')
                ->nullable()
                ->after('huong_dan_vien_id')
                ->constrained('phuong_tiens')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {

            $table->dropForeign(['phuong_tien_id']);
            $table->dropColumn('phuong_tien_id');

        });
    }
};
