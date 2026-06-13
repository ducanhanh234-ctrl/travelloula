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
        Schema::create('dich_vu_van_hanhs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ma_van_hanh_tour')
                ->constrained('van_hanh_tours')
                ->cascadeOnDelete();

            $table->string('loai_dich_vu');
            $table->string('ten_nha_cung_cap');
            $table->string('nguoi_lien_he')->nullable();
            $table->string('so_dien_thoai_lien_he')->nullable();
            $table->string('email_lien_he')->nullable();
            $table->string('ma_dat_dich_vu')->nullable();

            $table->integer('so_luong')->default(1);
            $table->decimal('chi_phi', 12, 2)->default(0);

            $table->enum('trang_thai', [
                'cho_xac_nhan',
                'da_xac_nhan',
                'da_huy'
            ])->default('cho_xac_nhan');

            $table->timestamp('han_xac_nhan')->nullable();
            $table->timestamp('thoi_gian_xac_nhan')->nullable();

            $table->text('yeu_cau_dich_vu')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->json('du_lieu_bo_sung')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dich_vu_van_hanhs');
    }
};
