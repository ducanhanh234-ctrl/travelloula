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
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {

            $table->dateTime('thoi_gian_check_out')
                ->nullable()
                ->after('thoi_gian_check_in');

            $table->enum('trang_thai', [
                'chua_check_in',
                'da_check_in',
                'da_check_out'
            ])->default('chua_check_in')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {

            $table->dropColumn('thoi_gian_check_out');
        });
    }
};
