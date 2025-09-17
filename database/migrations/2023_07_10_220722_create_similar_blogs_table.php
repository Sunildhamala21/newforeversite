<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimilarBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similar_blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('blog_id');
            $table->unsignedInteger('parent_id');
            $table->unique(['blog_id', 'parent_id']);
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
        Schema::dropIfExists('similar_blogs');
    }
}
