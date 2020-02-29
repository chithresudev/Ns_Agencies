<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('tank', ['a1', 'a2', 'b1', 'b2'])->nullable();
            $table->string('shift')->nullable();
            $table->string('shift_time')->nullable();
            $table->enum('fuel', ['petrol', 'diesel', 'speed'])->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->string('read_value')->nullable();
            $table->unsignedInteger('total_amt')->nullable();
            $table->date('insert_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuels');
    }
}
