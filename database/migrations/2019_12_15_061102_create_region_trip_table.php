<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionTripTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_trip', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions');
            $table->unsignedBigInteger('trip_id')->unsigned();
            $table->foreign('trip_id')->references('id')->on('trips');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('region_trip');
    }
}
