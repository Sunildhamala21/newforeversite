<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageNameFieldToTripReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_reviews', function (Blueprint $table) {
            $table->string('image_name')->nullable();
            $table->string('image_type')->nullable();
            $table->string('image_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trip_reviews', function (Blueprint $table) {
            //
        });
    }
}
