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
            $table->string('ten', 255)->unique();
            $table->string('ten_hien_thi', 255);
            $table->text('mo_ta')->nullable();
            $table->string('mo_dun', 255)->nullable();
            $table->boolean('trang_thai')->default(true);
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
