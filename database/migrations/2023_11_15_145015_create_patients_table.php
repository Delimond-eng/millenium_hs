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
        if(!Schema::hasTable("patients")){
            Schema::create('patients', function (Blueprint $table) {
                $table->id();
                $table->string('patient_code')->unique('patient_code');
                $table->string('patient_code_appel')->nullable();
                $table->string('patient_nom');
                $table->string('patient_prenom');
                $table->char('patient_sexe', 1);
                $table->char('patient_datenais', 10);
                $table->text('patient_adresse');
                $table->string('patient_telephone');
                $table->timestamp('patient_create_At')->useCurrentOnUpdate()->useCurrent();
                $table->string('patient_status', 10)->default('actif');
                $table->unsignedBigInteger('hopital_emplacement_id');
                $table->unsignedBigInteger('hopital_id');
                $table->unsignedBigInteger('created_by');
            });
        }

        /* Schema::table('patients', function (Blueprint $table) {
             $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete()->cascadeOnUpdate();
         }); */
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
