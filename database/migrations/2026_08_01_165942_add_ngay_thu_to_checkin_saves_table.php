<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checkin_saves', function (Blueprint $table) {
            $table->integer('ngay_thu')->nullable()->after('chi_tiet_lich_trinh_id');
        });
    }

    public function down(): void
    {
        Schema::table('checkin_saves', function (Blueprint $table) {
            $table->dropColumn('ngay_thu');
        });
    }
};
