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
        Schema::create('lien_hes', function (Blueprint $table) {

            $table->id();

            // Thông tin người gửi
            $table->string('ho_ten',150);

            $table->string('email',150);

            $table->string('so_dien_thoai',20);

            // Nội dung
            $table->string('tieu_de',255);

            $table->text('noi_dung');

            // Trạng thái
            $table->enum('trang_thai',[
                'Chưa xử lý',
                'Đã xử lý'
            ])->default('Chưa xử lý');

            // Ghi chú của admin
            $table->text('ghi_chu_admin')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lien_hes');
    }
};