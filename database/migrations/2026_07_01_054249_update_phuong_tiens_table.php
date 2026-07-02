<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {
            $table->string('ten_phuong_tien')->after('id');
            $table->integer('so_cho')->after('ten_phuong_tien');
            $table->string('bien_so')->nullable()->after('so_cho');
        });
    }

    public function down(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {
            $table->dropColumn([
                'ten_phuong_tien',
                'so_cho',
                'bien_so',

            ]);
        });
    }
};
