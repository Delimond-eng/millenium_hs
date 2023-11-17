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
        if(!Schema::hasTable("consultations")){
            Schema::create('consultations', function (Blueprint $table) {
                $table->id();
                $table->string('consult_libelle');
                $table->text('consult_obs');
                $table->timestamp('consult_create_At')->useCurrent();
                $table->string('consult_status')->default('actif');
                $table->unsignedBigInteger('patient_id');
                $table->unsignedBigInteger('agent_id');
            });
        }

        /* Schema::create('consultations', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('consultations');
    }
};