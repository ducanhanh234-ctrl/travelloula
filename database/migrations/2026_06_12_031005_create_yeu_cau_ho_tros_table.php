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
        Schema::create('yeu_cau_ho_tros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nguoi_dung_id')->comment('Mã người dùng gửi yêu cầu');
            $table->string('tieu_de', 255)->comment('Tiêu đề yêu cầu');
            $table->text('mo_ta')->comment('Nội dung mô tả');
            $table->string('trang_thai', 20)->comment('Trạng thái xử lý');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_ho_tros');
    }
};
