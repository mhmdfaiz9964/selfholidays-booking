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
            $table->id(); // Primary key
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade'); // Foreign key to hotels table
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('room_type_id')->constrained('room_categories'); // Foreign key to room_categories table
            $table->integer('number_of_children')->default(0);
            $table->integer('number_of_adults')->default(1);
            $table->json('supplements')->nullable(); // JSON column to store multiple supplement IDs
            $table->json('meals')->nullable(); // JSON column to store multiple meal options
            $table->date('checkin_date')->nullable();
            $table->date('checkout_date')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Nullable decimal column for price
            $table->text('message')->nullable(); // Nullable text column for additional message
            $table->timestamps(); // Created at and updated at timestamps
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
