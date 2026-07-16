<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bao_cao_su_cos', function (Blueprint $table) {

            $table->text('ghi_chu_xu_ly')
                ->nullable()
                ->after('trang_thai');

            $table->timestamp('thoi_gian_xu_ly')
                ->nullable()
                ->after('ghi_chu_xu_ly');

        });
    }

    public function down(): void
    {
        Schema::table('bao_cao_su_cos', function (Blueprint $table) {

            $table->dropColumn([
                'ghi_chu_xu_ly',
                'thoi_gian_xu_ly'
            ]);

        });
    }
};
