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
        Schema::create('examen_labo_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_libelle');
            $table->string('type_libelle_medical')->nullable();
            $table->string('type_description')->nullable();
            $table->unsignedBigInteger('examen_categorie_id');
            $table->timestamp('type_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_labo_types');
    }
};
