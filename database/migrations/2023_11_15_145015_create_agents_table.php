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
        Schema::create('agents', function (Blueprint $table) {
            $table->integer('agent_id', true);
            $table->string('agent_matricule')->unique();
            $table->string('agent_nom');
            $table->string('agent_prenom');
            $table->char('agent_sexe');
            $table->string('agent_telephone');
            $table->integer('agent_service_id');
            $table->integer('agent_grade_id');
            $table->integer('agent_fontion_id');
            $table->timestamp('agent_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->string('agent_status')->default('actif');

            $table->foreign('agent_service_id')->references('service_id')->on('services')->onDelete('cascade');
            $table->foreign('agent_grade_id')->references('grade_id')->on('grades')->onDelete('cascade');
            $table->foreign('agent_fontion_id')->references('fonction_id')->on('fonctions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
};