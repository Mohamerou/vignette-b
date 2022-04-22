<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enroll_histories', function (Blueprint $table) {
            $table->id();
            $table->string('townHallRef', 255);
            $table->string('agentRef', 255);
            $table->string('agentName', 255);
            $table->string('agentPhone', 255);
            $table->string('guichetRef', 255);
            $table->bigInteger('userId');
            $table->bigInteger('enginId')->nullable();
            $table->boolean('status')->default('0');
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
        Schema::dropIfExists('enroll_histories');
    }
}
