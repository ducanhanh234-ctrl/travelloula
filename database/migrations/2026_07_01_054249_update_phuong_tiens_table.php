<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {

            if (!Schema::hasColumn('phuong_tiens', 'ten_phuong_tien')) {
                $table->string('ten_phuong_tien')
                    ->nullable()
                    ->after('id');
            }

            if (!Schema::hasColumn('phuong_tiens', 'so_cho')) {
                $table->integer('so_cho')
                    ->nullable()
                    ->after('ten_phuong_tien');
            }

            if (!Schema::hasColumn('phuong_tiens', 'bien_so')) {
                $table->string('bien_so')
                    ->nullable()
                    ->after('so_cho');
            }

        });
    }

    public function down(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {

            if (Schema::hasColumn('phuong_tiens', 'bien_so')) {
                $table->dropColumn('bien_so');
            }

            if (Schema::hasColumn('phuong_tiens', 'so_cho')) {
                $table->dropColumn('so_cho');
            }

            if (Schema::hasColumn('phuong_tiens', 'ten_phuong_tien')) {
                $table->dropColumn('ten_phuong_tien');
            }
        });
    }
};

