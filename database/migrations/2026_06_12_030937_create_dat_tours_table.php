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
        Schema::create('dat_tours', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('booking_id');

            $table->string('full_name');
            $table->string('gender', 10);
            $table->integer('birth_year');

            $table->string('phone', 20);
            $table->string('email')->nullable();

            $table->string('id_number', 50);
            $table->string('id_type', 20);

            $table->string('passenger_type', 20);
            $table->string('payment_status', 20);

            $table->enum('check_in_status', [
                'pending',
                'checked_in',
                'checked_out'
            ])->default('pending');

            $table->timestamp('check_in_time')->nullable();

            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->decimal('amount_total', 12, 2);

            $table->text('special_requests')->nullable();

            $table->string('room_number')->nullable();
            $table->string('room_type')->nullable();

            $table->unsignedBigInteger('room_mate_id')->nullable();

            $table->boolean('checked_in')->default(false);

            $table->timestamp('checked_in_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dat_tours');
    }
};
