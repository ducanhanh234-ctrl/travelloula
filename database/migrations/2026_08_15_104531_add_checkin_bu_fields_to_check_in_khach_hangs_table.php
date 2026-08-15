<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {
            $table->boolean('is_checkin_bu')
                ->default(false)
                ->after('trang_thai');

            $table->text('ly_do_checkin_bu')
                ->nullable()
                ->after('is_checkin_bu');

            $table->timestamp('thoi_gian_ghi_nhan_bu')
                ->nullable()
                ->after('ly_do_checkin_bu');
        });
    }

    public function down(): void
    {
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {
            $table->dropColumn([
                'is_checkin_bu',
                'ly_do_checkin_bu',
                'thoi_gian_ghi_nhan_bu',
            ]);
        });
    }
};
