<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->boolean('da_checkin_khoi_hanh')->default(false)->after('da_gop');
        });
    }

    public function down(): void
    {
        Schema::table('lich_khoi_hanh_tours', function (Blueprint $table) {
            $table->dropColumn('da_checkin_khoi_hanh');
        });
    }
};
