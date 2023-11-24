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
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id();
            $table->string('patient_detail_poids', 5);
            $table->string('patient_detail_taille', 5);
            $table->string('patient_detail_temperature', 5);
            $table->string('patient_detail_tension_art', 5);
            $table->string('patient_detail_age', 5);
            $table->unsignedBigInteger('patient_id');
            $table->string('patient_detail_status')->default('actif');
            $table->timestamp('patient_detail_create_At')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_details');
    }
};