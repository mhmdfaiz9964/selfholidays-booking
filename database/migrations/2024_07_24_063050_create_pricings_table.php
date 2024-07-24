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
            $table->unsignedBigInteger('room_category_id');
            $table->string('meal');
            $table->decimal('sgl', 10, 2)->nullable();
            $table->decimal('dbl', 10, 2)->nullable();
            $table->decimal('tpl', 10, 2)->nullable();
            $table->decimal('quartable', 10, 2)->nullable();
            $table->decimal('family', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pricings');
    }
}