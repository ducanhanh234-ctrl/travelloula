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
        Schema::table('yeu_cau_gop_doans', function (Blueprint $table) {
            $table->string('dia_diem_de_xuat')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yeu_cau_gop_doans', function (Blueprint $table) {
            $table->string('dia_diem_de_xuat')
                ->nullable(false)
                ->change();
        });
    }
};
