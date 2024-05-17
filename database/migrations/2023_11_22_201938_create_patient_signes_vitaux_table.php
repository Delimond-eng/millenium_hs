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
        Schema::create('patient_signes_vitaux', function (Blueprint $table) {
            $table->id();
            $table->string('patient_sv_poids', 5)->nullable();
            $table->string('patient_sv_poids_unite', 5)->default('kg');
            $table->string('patient_sv_taille', 5)->nullable();
            $table->string('patient_sv_taille_unite', 5)->default('cm');
            $table->string('patient_sv_temperature', 5)->nullable();
            $table->string('patient_sv_temperature_unite', 5)->default('°c');
            $table->string('patient_sv_tension_art', 5)->nullable();
            $table->string('patient_sv_tension_art_unite', 5)->default('mmHg');
            $table->string('patient_sv_freq_cardio', 5)->nullable();
            $table->string('patient_sv_freq_cardio_unite', 5)->default('bpm');
            $table->string('patient_sv_saturation', 5)->nullable();
            $table->string('patient_sv_saturation_unite', 5)->default('%');
            $table->string('patient_sv_age', 5);
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('consult_id')->nullable();
            $table->string('patient_sv_status')->default('en attente');
            $table->timestamp('patient_sv_created_At')->useCurrentOnUpdate()->useCurrent();
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_signes_vitaux');
    }
};
