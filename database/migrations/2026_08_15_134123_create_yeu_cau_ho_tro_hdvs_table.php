<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yeu_cau_ho_tro_hdvs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lich_khoi_hanh_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->cascadeOnDelete();

            $table->string('loai_yeu_cau', 50)->default('thay_hdv');
            $table->string('tieu_de')->default('Yêu cầu thay hướng dẫn viên');
            $table->text('ly_do');

            // cho_xu_ly | da_xu_ly | tu_choi
            $table->string('trang_thai', 30)->default('cho_xu_ly');

            $table->foreignId('huong_dan_vien_thay_the_id')
                ->nullable()
                ->constrained('huong_dan_viens')
                ->nullOnDelete();

            $table->unsignedBigInteger('admin_xu_ly_id')->nullable();
            $table->text('phan_hoi_admin')->nullable();
            $table->timestamp('thoi_gian_xu_ly')->nullable();

            $table->timestamps();

            $table->index(
                ['lich_khoi_hanh_id', 'trang_thai'],
                'yc_hdv_lich_status_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_ho_tro_hdvs');
    }
};
