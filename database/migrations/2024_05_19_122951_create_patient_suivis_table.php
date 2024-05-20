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
        Schema::create('patient_suivis', function (Blueprint $table) {
            $table->id();
            $table->string('suivi_etat')->default('stable');
            $table->string('suivi_obs')->nullable();
            $table->string('suivi_recommandations')->nullable();
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
        Schema::dropIfExists('patient_suivis');
    }
};
