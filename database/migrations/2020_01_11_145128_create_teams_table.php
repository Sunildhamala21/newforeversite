<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('slug')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_size')->nullable();
            $table->string('image_type')->nullable();
            $table->string('image_alt')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('sort_order')->default(0);
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
        Schema::dropIfExists('teams');
    }
}
