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
        Schema::create('phuong_tiens', function (Blueprint $table) {
            $table->id();
            $table->string('bien_so_xe');
            $table->string('loai_phuong_tien');
            $table->string('hang_xe');
            $table->smallInteger('nam_san_xuat');
            $table->string('mau_xe');
            $table->tinyInteger('trang_thai')->default(1);
            $table->string('ten_tai_xe');
            $table->string('so_dien_thoai_tai_xe');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phuong_tiens');
    }
};
