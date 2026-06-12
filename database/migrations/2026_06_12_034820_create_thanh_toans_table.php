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
        Schema::create('thanh_toans', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('booking_id');

            $table->string('payment_method');
            $table->decimal('amount', 15, 2);

            $table->string('status')->default('pending');

            $table->text('note')->nullable();

            $table->string('refund_proof')->nullable();

            $table->string('transaction_code')->nullable();

            $table->json('raw_response')->nullable();

            $table->timestamp('payment_date')->nullable();

            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('booking_id')
                  ->references('id')
                  ->on('dat_tours')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};
