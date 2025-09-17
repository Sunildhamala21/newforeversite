<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_id', 191);
            $table->string('full_name', 191)->nullable();
            $table->string('email', 191);
            $table->string('contact_number', 191)->nullable();
            $table->string('trip_name', 191)->nullable();
            $table->string('amount', 191)->nullable();
            $table->string('price', 191)->nullable();
            $table->bigInteger('ref_id');
            $table->tinyInteger('status')->default('2');
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
        Schema::dropIfExists('invoices');
    }
}
