<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTripItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_itineraries', function (Blueprint $table) {
            $table->text('max_altitude')->nullable();
            $table->text('accomodation')->nullable();
            $table->text('meals')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trip_itineraries', function (Blueprint $table) {
            $table->dropColumn('max_altitude');
            $table->dropColumn('accomodation');
            $table->dropColumn('meals');
        });
    }
}
