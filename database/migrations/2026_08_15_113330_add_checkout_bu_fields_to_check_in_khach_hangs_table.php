<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {
            $table->boolean('is_checkout_bu')
                ->default(false)
                ->after('thoi_gian_ghi_nhan_bu');

            $table->text('ly_do_checkout_bu')
                ->nullable()
                ->after('is_checkout_bu');

            $table->timestamp('thoi_gian_ghi_nhan_checkout_bu')
                ->nullable()
                ->after('ly_do_checkout_bu');
        });
    }

    public function down(): void
    {
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {
            $table->dropColumn([
                'is_checkout_bu',
                'ly_do_checkout_bu',
                'thoi_gian_ghi_nhan_checkout_bu',
            ]);
        });
    }
};
