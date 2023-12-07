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
        Schema::create('examen_labos', function (Blueprint $table) {
            $table->id();
            $table->string('examen_labo_libelle');
            $table->string('examen_labo_description')->nullable()->default('...');
            $table->string('examen_labo_prix');
            $table->string('examen_labo_prix_devise')->default('CDF');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('examen_labo_create_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_labos');
    }
};
