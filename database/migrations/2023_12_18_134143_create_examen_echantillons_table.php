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
        Schema::create('examen_echantillons', function (Blueprint $table) {
            $table->id();
            $table->string('examen_echantillon_code');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('examen_id');
            $table->timestamp('examen_echantillon_date_prelevement');
            $table->string('resultat');
            $table->timestamp('examen_echantillon_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_echantillons');
    }
};
