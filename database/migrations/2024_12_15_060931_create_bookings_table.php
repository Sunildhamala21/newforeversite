<?php

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('country');
            $table->text('message')->nullable();
            $table->string('gender');
            $table->text('email');
            $table->text('phone');
            $table->unsignedInteger('amount');
            $table->string('type');
            $table->string('pay');
            $table->timestamps();
        });

        Schema::create('booking_trip', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Booking::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Trip::class)->constrained()->cascadeOnDelete();
            $table->unsignedInteger('no_of_travelers');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('price');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_trip');
        Schema::dropIfExists('bookings');
    }
};
