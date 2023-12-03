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
                $table->text('consult_diagnostic');
                $table->timestamp('consult_create_At')->useCurrent();
                $table->string('consult_status')->default('actif');
                $table->unsignedBigInteger('patient_id');
                $table->unsignedBigInteger('agent_id');
                $table->unsignedBigInteger('hopital_id');
                $table->unsignedBigInteger('hopital_emplacement_id');
            });
        }
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
