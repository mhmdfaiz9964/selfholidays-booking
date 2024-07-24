<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingHasSupplementsTable extends Migration
{
    public function up()
    {
        Schema::create('pricing_has_supplements', function (Blueprint $table) {
            $table->foreignId('supplements_id')->constrained('supplements');
            $table->foreignId('pricings_id')->constrained('pricings');
            $table->date('supplements_start_date');
            $table->date('supplements_end_date');
            $table->decimal('supplements_price', 10, 2);
            $table->primary(['supplements_id', 'pricings_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pricing_has_supplements');
    }
}