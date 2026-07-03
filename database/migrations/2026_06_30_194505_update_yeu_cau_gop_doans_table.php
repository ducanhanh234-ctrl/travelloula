<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('yeu_cau_gop_doans', function (Blueprint $table) {

            // Xóa khóa ngoại cũ
            $table->dropForeign(['lich_nguon_id']);
            $table->dropForeign(['lich_dich_id']);

            // Xóa cột cũ
            $table->dropColumn([
                'lich_nguon_id',
                'lich_dich_id'
            ]);

            // AI đề xuất xe bao nhiêu chỗ
            $table->unsignedTinyInteger('xe_de_xuat')
                ->nullable()
                ->after('loai_de_xuat');

            // Xe thực tế admin chọn
            $table->foreignId('phuong_tien_id')
                ->nullable()
                ->after('xe_de_xuat')
                ->constrained('phuong_tiens')
                ->nullOnDelete();

            // HDV admin chọn
            $table->foreignId('huong_dan_vien_id')
                ->nullable()
                ->after('phuong_tien_id')
                ->constrained('huong_dan_viens')
                ->nullOnDelete();

            // Thời điểm hoàn tất
            $table->timestamp('thoi_gian_hoan_tat')
                ->nullable()
                ->after('trang_thai');
        });
    }

    public function down(): void
    {
        Schema::table('yeu_cau_gop_doans', function (Blueprint $table) {

            $table->dropForeign(['phuong_tien_id']);
            $table->dropForeign(['huong_dan_vien_id']);

            $table->dropColumn([
                'xe_de_xuat',
                'phuong_tien_id',
                'huong_dan_vien_id',
                'thoi_gian_hoan_tat'
            ]);

            $table->foreignId('lich_nguon_id')
                ->constrained('lich_khoi_hanh_tours');

            $table->foreignId('lich_dich_id')
                ->constrained('lich_khoi_hanh_tours');
        });
    }
};
