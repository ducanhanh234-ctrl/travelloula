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
        Schema::table('phan_congs', function (Blueprint $table) {
            if (!Schema::hasColumn('phan_congs', 'phuong_tien_ids')) {
                $table->json('phuong_tien_ids')->nullable()->after('phuong_tien_id');
            }
            if (!Schema::hasColumn('phan_congs', 'hdv_ids')) {
                $table->json('hdv_ids')->nullable()->after('hdv_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phan_congs', function (Blueprint $table) {
            if (Schema::hasColumn('phan_congs', 'phuong_tien_ids')) {
                $table->dropColumn('phuong_tien_ids');
            }
            if (Schema::hasColumn('phan_congs', 'hdv_ids')) {
                $table->dropColumn('hdv_ids');
            }
        });
    }
};
