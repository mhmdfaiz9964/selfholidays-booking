<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelHasPricingTable extends Migration
{
    public function up()
    {
        Schema::create('hotel_has_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricings_id')->constrained('pricings');
            $table->unsignedBigInteger('hotel_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotel_has_pricing');
    }
}