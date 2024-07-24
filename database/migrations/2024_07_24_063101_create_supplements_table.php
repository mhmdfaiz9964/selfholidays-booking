<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplementsTable extends Migration
{
    public function up()
    {
        Schema::create('supplements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('hotel_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplements');
    }
}