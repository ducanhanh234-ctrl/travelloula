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
        Schema::create('hoa_dons', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('booking_id');

            $table->string('invoice_number', 100)->unique();

            $table->timestamp('issue_date')->nullable();

            $table->decimal('amount', 12, 2);

            $table->string('status', 20)->default('pending');

            $table->timestamps();

            // Foreign key
            $table->foreign('booking_id')
                  ->references('id')
                  ->on('dat_tours')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_dons');
    }
};
