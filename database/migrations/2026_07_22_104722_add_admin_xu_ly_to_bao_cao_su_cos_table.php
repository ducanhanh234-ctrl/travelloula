<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bao_cao_su_cos', function (Blueprint $table) {
            if (!Schema::hasColumn('bao_cao_su_cos', 'admin_xu_ly_id')) {
                $table->foreignId('admin_xu_ly_id')
                    ->nullable()
                    ->after('huong_dan_vien_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('bao_cao_su_cos', 'thoi_gian_tiep_nhan')) {
                $table->dateTime('thoi_gian_tiep_nhan')
                    ->nullable()
                    ->after('ghi_chu_xu_ly');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bao_cao_su_cos', function (Blueprint $table) {
            if (Schema::hasColumn('bao_cao_su_cos', 'admin_xu_ly_id')) {
                $table->dropForeign(['admin_xu_ly_id']);
                $table->dropColumn('admin_xu_ly_id');
            }

            if (Schema::hasColumn('bao_cao_su_cos', 'thoi_gian_tiep_nhan')) {
                $table->dropColumn('thoi_gian_tiep_nhan');
            }
        });
    }
};
