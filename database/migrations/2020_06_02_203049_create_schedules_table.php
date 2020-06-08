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
            $table->timestamps();
            $table->boolean('flag')->default(1);
            $table->integer('user_id');   
            $table->string('caller_fname');
            $table->string('caller_lname');
            $table->string('caller_email');
            $table->integer('type_id');
            $table->dateTime('call_date');
            $table->string('call_time');
            $table->timestamp('call_timestamp');
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
