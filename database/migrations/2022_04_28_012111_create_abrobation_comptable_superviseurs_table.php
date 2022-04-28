<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbrobationComptableSuperviseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abrobation_comptable_superviseurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('superviseurId')->constrained('users');
            $table->foreignId('newAgentId')->unique()->constrained('users');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('abrobation_comptable_superviseurs');
    }
}
