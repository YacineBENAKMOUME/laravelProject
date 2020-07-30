<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missiones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Direction');
            $table->string('Departement');
            $table->string('Demandeeffectueepar');
            $table->string('Compteanalytique');
            $table->date('Datedemande');
            $table->string('Destinataire');
            $table->date('Periodedelamissionde');
            $table->date('Au');
            $table->integer('Nombredejours');
            $table->string('Objetdelamission');
            $table->string('Lieudelamission');
            $table->string('Pays');
            $table->string('Cadredelamission');
            $table->string('Informationcomplementaire');
            $table->mediumText('Nomsmissionaires');
            $table->string('Situationvisa');
            $table->string('Informationcomplementairevisa');
            $table->date('Dateexpirationdespasseports');
            $table->string('Objectifsdelamission');
            $table->string('Opportunitemission');
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
        Schema::dropIfExists('missiones');
    }
}
