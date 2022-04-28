<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('lastname', 255);
            $table->string('firstname', 255);
            $table->boolean('gender')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('address', 255);
            $table->boolean('isverified')->default(false);
            $table->string('administration', 255)->nullable();
            $table->string('idCard', 255)->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone', 255)->unique();
            $table->string('code', 255)->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('notification_prefernce', 255)->default('mail');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
