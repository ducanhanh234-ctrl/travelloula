<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nếu model CheckInKhachHang của bạn dùng tên bảng khác,
        // đổi 'check_in_khach_hangs' thành đúng $table của model.
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {
            $table->string('checkin_context', 20)
                ->default('activity')
                ->after('chi_tiet_lich_trinh_id')
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('check_in_khach_hangs', function (Blueprint $table) {
            $table->dropColumn('checkin_context');
        });
    }
};
