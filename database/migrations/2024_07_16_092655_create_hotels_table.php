<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rating')->nullable();
            $table->unsignedBigInteger('location_id'); // Assuming location is stored as district ID
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('group_of_company')->nullable();
            $table->string('sales_manager_name')->nullable();
            $table->string('sales_manager_contact')->nullable();
            $table->unsignedBigInteger('room_category_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('room_category_id')->references('id')->on('room_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
};
