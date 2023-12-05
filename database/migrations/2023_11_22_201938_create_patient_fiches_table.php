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
        Schema::create('patient_fiches', function (Blueprint $table) {
            $table->id();
            $table->string('patient_fiche_poids', 5);
            $table->string('patient_fiche_poids_unite', 5)->default('kg');
            $table->string('patient_fiche_taille', 5);
            $table->string('patient_fiche_taille_unite', 5)->default('cm');
            $table->string('patient_fiche_temperature', 5);
            $table->string('patient_fiche_temperature_unite', 5)->default('°c');
            $table->string('patient_fiche_tension_art', 5);
            $table->string('patient_fiche_tension_art_unite', 5)->default('mmHg');
            $table->string('patient_fiche_freq_cardio', 5);
            $table->string('patient_fiche_freq_cardio_unite', 5)->default('bpm');
            $table->string('patient_fiche_age', 5);
            $table->unsignedBigInteger('patient_id');
            $table->string('patient_fiche_status')->default('actif');
            $table->timestamp('patient_fiche_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('hopital_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_details');
    }
};
