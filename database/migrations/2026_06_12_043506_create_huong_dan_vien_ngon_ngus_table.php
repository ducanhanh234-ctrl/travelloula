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
        Schema::create('huong_dan_vien_ngon_ngus', function (Blueprint $table) {
            $table->foreignId('huong_dan_vien_id')
                ->constrained('huong_dan_viens')
                ->onDelete('cascade');
            $table->foreignId('ngon_ngu_id')
                ->constrained('ngon_ngus')
                ->onDelete('cascade');
            $table->string('ten_trinh_do', 100);
            $table->primary(['huong_dan_vien_id', 'ngon_ngu_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('huong_dan_vien_ngon_ngus');
    }
};
