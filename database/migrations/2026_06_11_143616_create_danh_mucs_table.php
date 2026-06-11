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
        Schema::create('danh_mucs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_danh_muc', 100);
            $table->text('mo_ta')->nullable();
            $table->string('hinh_anh', 255)->nullable();
            $table->string('trang_thai', 20)->default('Hoạt động');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_mucs');
    }
};
