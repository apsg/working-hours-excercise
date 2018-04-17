<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_intervals', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->onDelete('cascade');

            $table->date('date');
            $table->unique(['employee_id', 'date']);

            $table->time('starting_hour');
            $table->time('ending_hour');

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
        Schema::dropIfExists('time_intervals');
    }
}
