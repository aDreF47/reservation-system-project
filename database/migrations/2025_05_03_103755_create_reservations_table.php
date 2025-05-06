<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reservable_type'); // Para relación polimórfica
            $table->unsignedBigInteger('reservable_id');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->integer('guests');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->timestamps();

            $table->index(['reservable_type', 'reservable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
