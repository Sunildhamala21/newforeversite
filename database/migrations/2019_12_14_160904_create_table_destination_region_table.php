<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDestinationRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination_region', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('destination_id')->unsigned();
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
            $table->unsignedBigInteger('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
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
        Schema::dropIfExists('destination_region');
    }
}
