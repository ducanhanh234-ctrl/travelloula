<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {

            $table->string('bien_so_xe')->after('id');

            $table->string('loai_phuong_tien')->after('bien_so_xe');

            $table->string('hang_xe')->after('loai_phuong_tien');

            $table->smallInteger('nam_san_xuat')->after('hang_xe');

            $table->string('mau_xe')->after('nam_san_xuat');

            $table->tinyInteger('trang_thai')
                ->default(1)
                ->after('mau_xe');

            $table->string('ten_tai_xe')
                ->after('trang_thai');

            $table->string('so_dien_thoai_tai_xe')
                ->after('ten_tai_xe');

            $table->text('ghi_chu')
                ->nullable()
                ->after('so_dien_thoai_tai_xe');
        });
    }

    public function down(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {

            $table->dropColumn([
                'bien_so_xe',
                'loai_phuong_tien',
                'hang_xe',
                'nam_san_xuat',
                'mau_xe',
                'trang_thai',
                'ten_tai_xe',
                'so_dien_thoai_tai_xe',
                'ghi_chu',
            ]);
        });
    }
};