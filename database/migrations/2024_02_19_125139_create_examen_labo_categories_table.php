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
        Schema::create('examen_labo_categories', function (Blueprint $table) {
            $table->id();
            $table->string('categorie_libelle');
            $table->string('categorie_description')->nullable();
            $table->unsignedBigInteger('labo_id')->nullable();
            $table->timestamp('categorie_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('examen_labo_categories');
    }
};
