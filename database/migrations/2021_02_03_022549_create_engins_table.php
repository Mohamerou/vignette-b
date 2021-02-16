<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users');
            $table->string('marque');
            $table->string('modele');
            $table->string('mairie');
            $table->string('chassie')->unique()->nullable();
            $table->string('immatriculation')->unique()->nullable();
            $table->string('puissanceFiscale');
            $table->integer('tarif');
            $table->string('documentJustificatif')->nullable();
            $table->foreignId('vignetteId')->unique()->nullable()
                                           ->constrained('vignettes');
            $table->boolean('signaler_perdue')->default(0);
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
        Schema::dropIfExists('engins');
    }
}
