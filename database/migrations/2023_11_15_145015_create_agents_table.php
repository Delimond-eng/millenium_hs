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
        if(!Schema::hasTable("agents")){
            Schema::create('agents', function (Blueprint $table) {
                $table->id();
                $table->string('agent_matricule')->unique();
                $table->string('agent_nom');
                $table->string('agent_prenom');
                $table->char('agent_sexe');
                $table->string('agent_telephone');
                $table->text('agent_adresse');
                $table->timestamp('agent_create_At')->useCurrentOnUpdate()->useCurrent();
                $table->string('agent_status')->default('actif');
                $table->unsignedBigInteger('grade_id');
                $table->unsignedBigInteger('service_id');
                $table->unsignedBigInteger('fonction_id');
            });
        }

        /* Schema::table('agents', function (Blueprint $table) {
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('fonction_id')->constrained('fonctions')->cascadeOnDelete()->cascadeOnUpdate();
        }); */
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
