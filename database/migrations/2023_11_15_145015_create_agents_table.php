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
            $table->id();
            $table->string('agent_matricule')->unique();
            $table->string('agent_nom');
            $table->string('agent_prenom');
            $table->char('agent_sexe');
            $table->string('agent_telephone');
            $table->text('agent_adresse')->nullable();
            $table->string('agent_datenais')->nullable();
            $table->string('agent_specialite')->nullable();
            $table->timestamp('agent_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->string('agent_status')->default('actif');
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('fonction_id')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
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
        Schema::dropIfExists('agents');
    }
};
