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
        Schema::create('quyen_hans', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 255); // Tên quyền hạn

            $table->string('ten_hien_thi', 255); // Tên hiển thị quyền hạn

            $table->text('mo_ta')->nullable(); // Mô tả quyền hạn

            $table->string('mo_dun', 255); // Nhóm chức năng / module

            $table->boolean('trang_thai')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quyen_hans');
    }
};
