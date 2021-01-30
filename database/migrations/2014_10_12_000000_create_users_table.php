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
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->boolean('gender');
            $table->string('avatar')->nullable();
            $table->string('address');
            $table->boolean('isverified')->default(false);
            $table->string('administration')->nullable();
            $table->string('idCard')->nullable();
            $table->string('phone')->unique();
            $table->string('code')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->string('notification_prefernce')->default('mail');
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
