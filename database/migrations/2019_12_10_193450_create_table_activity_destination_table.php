<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableActivityDestinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_destination', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('destination_id')->unsigned();
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
            $table->unsignedBigInteger('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
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
        Schema::dropIfExists('activity_destination');
    }
}
