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
            $table->id();
            $table->string('csrf_token')->nullable();
            $table->string('site_id')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('chassie')->nullable();
            $table->string('cylindre')->nullable();
            $table->string('amount')->nullable();
            $table->string('trans_id')->nullable();
            $table->string('trans_date')->nullable();
            $table->string('page_action')->nullable();
            $table->string('payment_config')->nullable();
            $table->string('version')->nullable();
            $table->string('return_mode')->nullable();
            $table->string('result')->nullable();
            $table->string('trans_status')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('payment_time')->nullable();
            $table->string('currency')->nullable();
            $table->string('language')->nullable();
            $table->integer('custom')->nullable();
            $table->string('signature')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('cel_phone_num')->nullable();
            $table->integer('cel_phone_prefixe')->nullable();
            $table->string('error_message')->nullable();
            $table->string('payid')->nullable();
            $table->string('ipaddr')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
