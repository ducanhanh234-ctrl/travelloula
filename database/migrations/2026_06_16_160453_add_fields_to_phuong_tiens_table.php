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
                $table->string('bien_so_xe')->nullable()->after('id');
            }

            if (!Schema::hasColumn('phuong_tiens', 'loai_phuong_tien')) {
                $table->string('loai_phuong_tien')->nullable()->after('bien_so_xe');
            }

            if (!Schema::hasColumn('phuong_tiens', 'hang_xe')) {
                $table->string('hang_xe')->nullable()->after('loai_phuong_tien');
            }

            if (!Schema::hasColumn('phuong_tiens', 'nam_san_xuat')) {
                $table->smallInteger('nam_san_xuat')->nullable()->after('hang_xe');
            }

            if (!Schema::hasColumn('phuong_tiens', 'mau_xe')) {
                $table->string('mau_xe')->nullable()->after('nam_san_xuat');
            }

            if (!Schema::hasColumn('phuong_tiens', 'so_cho')) {
                $table->integer('so_cho')->nullable()->after('mau_xe');
            }

            if (!Schema::hasColumn('phuong_tiens', 'trang_thai')) {
                $table->tinyInteger('trang_thai')->default(1)->after('so_cho');
            }

            if (!Schema::hasColumn('phuong_tiens', 'ten_tai_xe')) {
                $table->string('ten_tai_xe')->nullable()->after('trang_thai');
            }

            if (!Schema::hasColumn('phuong_tiens', 'so_dien_thoai_tai_xe')) {
                $table->string('so_dien_thoai_tai_xe')->nullable()->after('ten_tai_xe');
            }

            if (!Schema::hasColumn('phuong_tiens', 'ghi_chu')) {
                $table->text('ghi_chu')->nullable()->after('so_dien_thoai_tai_xe');
            }
        });
    }

    public function down(): void
    {
        Schema::table('phuong_tiens', function (Blueprint $table) {
            $columns = [
                'ghi_chu',
                'so_dien_thoai_tai_xe',
                'ten_tai_xe',
                'trang_thai',
                'so_cho',
                'mau_xe',
                'nam_san_xuat',
                'hang_xe',
                'loai_phuong_tien',
                'bien_so_xe',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('phuong_tiens', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
