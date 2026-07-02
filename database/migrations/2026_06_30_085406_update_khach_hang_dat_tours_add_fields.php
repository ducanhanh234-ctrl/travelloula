<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('khach_hang_dat_tours', function (Blueprint $table) {

            if (!Schema::hasColumn('khach_hang_dat_tours', 'ngay_sinh')) {
                $table->date('ngay_sinh')
                    ->nullable()
                    ->after('nam_sinh');
            }


            if (!Schema::hasColumn('khach_hang_dat_tours', 'quoc_tich')) {
                $table->string('quoc_tich', 100)
                    ->nullable()
                    ->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('khach_hang_dat_tours', function (Blueprint $table) {

            $table->dropColumn([
                'ngay_sinh',
                'quoc_tich'
            ]);
        });
    }
};
