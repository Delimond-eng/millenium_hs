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
        Schema::create('partener_agents', function (Blueprint $table) {
            $table->id();
            $table->string('agent_matricule');
            $table->string('agent_num_convention');
            $table->string('agent_nom');
            $table->string('agent_prenom');
            $table->string('agent_sexe');
            $table->string('agent_etat_civil');
            $table->integer('agent_nbre_efts');
            $table->unsignedBigInteger('partener_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('agent_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partener_agents');
    }
};
