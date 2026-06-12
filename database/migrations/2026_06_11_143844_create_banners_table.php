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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
             $table->string('tieu_de', 200);
            $table->text('mo_ta')->nullable();

            $table->string('hinh_anh', 500);
            $table->string('duong_dan_lien_ket', 500)->nullable();

            $table->enum('loai_banner', [
                'slider',
                'popup',
                'sidebar',
                'homepage'
            ]);

            $table->enum('vi_tri_hien_thi', [
                'top',
                'middle',
                'bottom',
                'left',
                'right'
            ]);

            $table->integer('thu_tu_hien_thi')->default(0);

            $table->boolean('trang_thai_hoat_dong')->default(true);

            $table->timestamp('ngay_bat_dau')->nullable();
            $table->timestamp('ngay_ket_thuc')->nullable();

            $table->json('doi_tuong_hien_thi')->nullable();

            $table->integer('luot_nhap')->default(0);
            $table->integer('luot_xem')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
