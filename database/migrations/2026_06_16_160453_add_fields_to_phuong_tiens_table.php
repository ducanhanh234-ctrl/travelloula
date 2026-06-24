<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {
            if (!Schema::hasColumn('phuong_tiens', 'bien_so_xe')) {
                $table->string('bien_so_xe')->after('id');
            }

            if (!Schema::hasColumn('phuong_tiens', 'loai_xe')) {
                $table->string('loai_xe')->nullable()->after('bien_so_xe');
            }

            if (!Schema::hasColumn('phuong_tiens', 'so_cho')) {
                $table->integer('so_cho')->nullable()->after('loai_xe');
            }

            if (!Schema::hasColumn('phuong_tiens', 'trang_thai')) {
                $table->tinyInteger('trang_thai')->default(1)->after('so_cho');
            }
        });
    }

    public function down(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {
            if (Schema::hasColumn('phuong_tiens', 'trang_thai')) {
                $table->dropColumn('trang_thai');
            }

            if (Schema::hasColumn('phuong_tiens', 'so_cho')) {
                $table->dropColumn('so_cho');
            }

            if (Schema::hasColumn('phuong_tiens', 'loai_xe')) {
                $table->dropColumn('loai_xe');
            }

            if (Schema::hasColumn('phuong_tiens', 'bien_so_xe')) {
                $table->dropColumn('bien_so_xe');
            }
        });
    }
};