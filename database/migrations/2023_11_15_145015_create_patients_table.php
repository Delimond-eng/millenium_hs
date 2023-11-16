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
        Schema::create('patients', function (Blueprint $table) {
            $table->integer('patient_id', true);
            $table->string('patient_code')->unique('patient_code');
            $table->string('patient_nom');
            $table->string('patient_prenom');
            $table->char('patient_sexe', 1);
            $table->float('patient_poids', 10, 0);
            $table->float('patient_temperature', 10, 0);
            $table->integer('patient_age');
            $table->text('patient_adresse');
            $table->string('patient_telephone');
            $table->decimal('patient_taille', 10, 0);
            $table->timestamp('patient_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->string('patient_status', 10)->default('actif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
