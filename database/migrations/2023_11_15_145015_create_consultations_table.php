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
        Schema::create('consultations', function (Blueprint $table) {
            $table->integer('consut_id', true);
            $table->string('consult_libelle');
            $table->text('consult_obs');
            $table->integer('consult_agent_id');
            $table->integer('consult_patient_id');
            $table->timestamp('consult_create_At')->useCurrent();
            $table->string('consult_status')->default('actif');

            $table->foreign('consult_agent_id')->references('agent_id')->on('agents')->onDelete('cascade');
            $table->foreign('consult_patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
};