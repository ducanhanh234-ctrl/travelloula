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
        Schema::table('thanh_toans', function (Blueprint $table) {
            $table->string('hoa_don_pdf')->nullable()->after('ma_giao_dich');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thanh_toans', function (Blueprint $table) {
            $table->dropColumn('hoa_don_pdf');
        });
    }
};
