<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id')->unsigned();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->longText('accomodation')->nullable();
            $table->longText('meals')->nullable();
            $table->longText('transportation')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('highlights')->nullable();
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
        Schema::dropIfExists('trip_infos');
    }
}
