<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('diem_danh_khach_hangs', function (Blueprint $table) {
            $table->integer('ngay_thu')
                ->default(1)
                ->after('ngay_diem_danh');
        });
    }

    public function down()
    {
        Schema::table('diem_danh_khach_hangs', function (Blueprint $table) {
            $table->dropColumn('ngay_thu');
        });
    }
};
