<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialOfferToPricingTable extends Migration
{
    public function up()
    {
        Schema::table('pricings', function (Blueprint $table) {
            // Add ENUM column with default value
            $table->enum('special_offer', ['enable', 'disable'])->default('disable');
        });
    }

    public function down()
    {
        Schema::table('pricings', function (Blueprint $table) {
            // Remove ENUM column
            $table->dropColumn('special_offer');
        });
    }
}
