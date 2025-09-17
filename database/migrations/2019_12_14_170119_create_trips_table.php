<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('duration')->nullable();
            $table->double('max_altitude', 8, 2)->nullable();
            $table->string('group_size')->nullable();
            $table->double('cost', 8, 2)->nullable();
            $table->double('offer_price', 8, 2)->nullable();
            $table->tinyInteger('difficulty_grade')->nullable();
            $table->string('starting_point')->nullable();
            $table->string('ending_point')->nullable();
            $table->string('map_file_name')->nullable();
            $table->string('pdf_file_name')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('show_status')->default(1)->comment('1=show, 2=hide');
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
        Schema::dropIfExists('trips');
    }
}
