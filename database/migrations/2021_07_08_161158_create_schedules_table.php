<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('time');
            $table->string('name');
            $table->enum('type', ['kids', 'adults', 'general'])->nullable();
            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('line3')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('images')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

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
        Schema::dropIfExists('schedules');
    }
}
