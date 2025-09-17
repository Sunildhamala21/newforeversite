<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('destination_id')->nullable()->unsigned();
            $table->foreign('destination_id')->references('id')->on('destinations');
            $table->string('slug');
            $table->string('name');
            $table->string('image_name')->nullable();
            $table->string('image_type')->nullable();
            $table->string('image_size')->nullable();
            $table->string('image_alt')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('activities');
    }
}
