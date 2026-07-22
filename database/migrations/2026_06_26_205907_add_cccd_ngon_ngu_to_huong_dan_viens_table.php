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
        Schema::table('huong_dan_viens', function (Blueprint $table) {
            if (!Schema::hasColumn('huong_dan_viens', 'so_cccd')) {
                $table->string('so_cccd', 20)->nullable()->after('email');
            }

            if (!Schema::hasColumn('huong_dan_viens', 'ngay_cap_cccd')) {
                $table->date('ngay_cap_cccd')->nullable()->after('so_cccd');
            }

            if (!Schema::hasColumn('huong_dan_viens', 'noi_cap_cccd')) {
                $table->string('noi_cap_cccd', 255)->nullable()->after('ngay_cap_cccd');
            }

            if (!Schema::hasColumn('huong_dan_viens', 'anh_cccd_truoc')) {
                $table->string('anh_cccd_truoc', 255)->nullable()->after('noi_cap_cccd');
            }

            if (!Schema::hasColumn('huong_dan_viens', 'anh_cccd_sau')) {
                $table->string('anh_cccd_sau', 255)->nullable()->after('anh_cccd_truoc');
            }

            if (!Schema::hasColumn('huong_dan_viens', 'ngon_ngu_thanh_thao')) {
                $table->string('ngon_ngu_thanh_thao', 255)->nullable()->after('so_nam_kinh_nghiem');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('huong_dan_viens', function (Blueprint $table) {
            if (Schema::hasColumn('huong_dan_viens', 'ngon_ngu_thanh_thao')) {
                $table->dropColumn('ngon_ngu_thanh_thao');
            }

            if (Schema::hasColumn('huong_dan_viens', 'anh_cccd_sau')) {
                $table->dropColumn('anh_cccd_sau');
            }

            if (Schema::hasColumn('huong_dan_viens', 'anh_cccd_truoc')) {
                $table->dropColumn('anh_cccd_truoc');
            }

            if (Schema::hasColumn('huong_dan_viens', 'noi_cap_cccd')) {
                $table->dropColumn('noi_cap_cccd');
            }

            if (Schema::hasColumn('huong_dan_viens', 'ngay_cap_cccd')) {
                $table->dropColumn('ngay_cap_cccd');
            }

            if (Schema::hasColumn('huong_dan_viens', 'so_cccd')) {
                $table->dropColumn('so_cccd');
            }
        });
    }
};
