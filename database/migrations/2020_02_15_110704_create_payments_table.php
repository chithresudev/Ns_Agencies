<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('type', ['paytm', 'cash','checque', 'card'])->nullable();
            $table->enum('fuel', ['petrol', 'diesel', 'speed'])->nullable();
            $table->unsignedInteger('in_amount')->nullable();
            $table->unsignedInteger('out_amount')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedInteger('bal_amt')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
