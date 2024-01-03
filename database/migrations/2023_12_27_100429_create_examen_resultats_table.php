<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_resultats', function (Blueprint $table) {
            $table->id();
            $table->string('examen_resultat_libelle');
            $table->text('examen_resultat_description')->nullable();
            $table->string('examen_resultat_media')->nullable();
            $table->unsignedBigInteger('examen_id');
            $table->unsignedBigInteger('echantillon_id');
            $table->unsignedBigInteger('labo_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('suivi_id')->default(0)->nullable();
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp("examen_resultat_created_At")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_resultats');
    }
};
