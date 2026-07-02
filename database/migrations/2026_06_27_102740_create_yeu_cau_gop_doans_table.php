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
        Schema::create('yeu_cau_gop_doans', function (Blueprint $table) {

            $table->id();

            // Mã yêu cầu (VD: YG000001)
            $table->string('ma_yeu_cau')->unique();

            // Lịch bị gộp (đoàn nguồn)
            $table->foreignId('lich_nguon_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            // Lịch nhận khách (đoàn đích)
            $table->foreignId('lich_dich_id')
                ->constrained('lich_khoi_hanh_tours')
                ->cascadeOnDelete();

            // Điểm do thuật toán chấm
            $table->unsignedTinyInteger('diem_de_xuat');

            // Lý do hệ thống đề xuất
            $table->text('ly_do_de_xuat')->nullable();

            // Đề xuất tự động hay admin tự tạo
            $table->enum('loai_de_xuat', [
                'tu_dong',
                'thu_cong'
            ])->default('tu_dong');

            // Trạng thái xử lý
            $table->enum('trang_thai', [
                'cho_xu_ly',
                'dang_lien_he',
                'hoan_tat',
                'huy'
            ])->default('cho_xu_ly');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_gop_doans');
    }
};
