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
        Schema::create('thong_baos', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('tieu_de')
                ->nullable();

            $table->text('noi_dung')
                ->nullable();

            $table->string('loai_thong_bao', 20)
                ->default('he_thong');

            $table->string('trang_thai', 20)
                ->default('chua_doc');

            $table->string('loai_lien_quan')
                ->nullable();

            $table->unsignedBigInteger('id_lien_quan')
                ->nullable();

            $table->json('du_lieu')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_baos');
    }
};
