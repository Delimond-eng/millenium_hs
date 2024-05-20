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
        Schema::create('patient_traitements', function (Blueprint $table) {
            $table->id();
            $table->string('traitement_obs')->nullable();
            $table->string('traitement_status')->default('actif');
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->unsignedBigInteger('suivi_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
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
        Schema::dropIfExists('patient_traitements');
    }
};
