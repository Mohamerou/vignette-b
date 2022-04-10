<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', 255);
            $table->string('firstname', 255);
            $table->string('avatar', 255)->nullable();
            $table->string('address', 255);
            $table->boolean('isverified')->default(true);
            $table->string('townHallRef', 255);
            $table->string('guichetRef', 255);
            $table->string('phone', 255)->unique();
            $table->string('code', 255)->nullable();
            $table->string('password', 255);
            $table->string('notification_prefernce', 255)->default('mail');
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
        Schema::dropIfExists('agents');
    }
}
