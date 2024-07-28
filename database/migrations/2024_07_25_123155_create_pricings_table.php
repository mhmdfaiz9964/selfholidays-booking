<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingsTable extends Migration
{
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->json('supplements_id')->nullable(); // Storing array as JSON
            $table->json('meals_id')->nullable(); // Storing array as JSON
            $table->string('type', 255);
            $table->decimal('sgl', 10, 2);
            $table->decimal('dbl', 10, 2);
            $table->decimal('tpl', 10, 2);
            $table->decimal('Quartable', 10, 2);
            $table->decimal('Family', 10, 2);
            $table->date('Start_date');
            $table->date('End_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pricing');
    }
}
