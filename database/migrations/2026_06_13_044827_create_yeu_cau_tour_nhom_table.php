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
        Schema::create('yeu_cau_tour_nhom', function (Blueprint $table) {
            $table->id();

            $table->foreignId('khach_hang_dat_tour_id')
                ->nullable()
                ->constrained('khach_hang_dat_tours')
                ->nullOnDelete();

            $table->string('ten_doan', 255);

            $table->string('nguoi_lien_he', 255);

            $table->string('so_dien_thoai', 20);

            $table->string('email', 255)->nullable();

            $table->string('diem_den', 255);

            $table->string('dia_diem_khoi_hanh', 255)->nullable();

            $table->date('ngay_khoi_hanh_du_kien');

            $table->integer('so_luong_nguoi');

            $table->integer('so_ngay_du_kien')->nullable();

            $table->decimal('ngan_sach_du_kien', 12, 2)->nullable();

            $table->text('yeu_cau_dac_biet')->nullable();

            $table->enum('trang_thai', [
                'moi_tao',
                'dang_tu_van',
                'bao_gia',
                'xac_nhan',
                'huy'
            ])->default('moi_tao');

            $table->text('ghi_chu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_tour_nhom');
    }
};
