<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->json('meal_ids')->nullable();
            $table->json('supplement_ids')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('full_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('room_type'); // Add room type here
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->integer('adults');
            $table->integer('children');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
