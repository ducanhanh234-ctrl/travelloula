<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('yeu_cau_gop_doans', function (Blueprint $table) {

            // đổi tên cột
            $table->renameColumn('diem_de_xuat', 'dia_diem_de_xuat');
        });
    }

    public function down(): void
    {
        Schema::table('yeu_cau_gop_doans', function (Blueprint $table) {

            $table->renameColumn('dia_diem_de_xuat', 'diem_de_xuat');
        });
    }
};
