<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomPricingTable extends Migration
{
    public function up()
    {
        Schema::create('room_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('room_category_id')->constrained('room_categories')->onDelete('cascade');
            $table->decimal('room_only_price', 10, 2)->nullable();
            $table->date('room_only_start_date')->nullable();
            $table->date('room_only_end_date')->nullable();
            $table->decimal('bed_and_breakfast_price', 10, 2)->nullable();
            $table->date('bed_and_breakfast_start_date')->nullable();
            $table->date('bed_and_breakfast_end_date')->nullable();
            $table->decimal('half_board_price', 10, 2)->nullable();
            $table->date('half_board_start_date')->nullable();
            $table->date('half_board_end_date')->nullable();
            $table->decimal('full_board_price', 10, 2)->nullable();
            $table->date('full_board_start_date')->nullable();
            $table->date('full_board_end_date')->nullable();
            $table->decimal('all_inclusive_price', 10, 2)->nullable();
            $table->date('all_inclusive_start_date')->nullable();
            $table->date('all_inclusive_end_date')->nullable();
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('room_category_id')->references('id')->on('room_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_pricing');
    }
}
