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
            $table->string('consult_libelle', 100);
            $table->text('consult_obs');
            $table->integer('consult_agent_id');
            $table->integer('consult_patient_id');
            $table->timestamp('consult_create_At')->useCurrent();
            $table->string('consult_status', 10)->default('actif');
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