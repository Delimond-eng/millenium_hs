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
            $table->string('agent_matricule', 25)->unique();
            $table->string('agent_nom', 50);
            $table->string('agent_prenom', 50);
            $table->char('agent_sexe', 1);
            $table->string('agent_telephone', 15);
            $table->integer('agent_service_id');
            $table->integer('agent_grade_id');
            $table->integer('agent_fontion_id');
            $table->timestamp('agent_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->string('agent_status', 10)->default('actif');
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