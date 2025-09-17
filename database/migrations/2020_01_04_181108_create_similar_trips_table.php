<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimilarTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similar_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('trip_id');
            $table->unsignedInteger('parent_id');
            $table->unique(['trip_id', 'parent_id']);
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
        Schema::dropIfExists('similar_trips');
    }
}
