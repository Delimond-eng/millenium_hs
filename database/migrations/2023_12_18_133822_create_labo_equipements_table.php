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
        Schema::create('labo_equipements', function (Blueprint $table) {
            $table->id();
            $table->string('labo_equipement_nom');
            $table->text('labo_equipement_description')->nullable();
            $table->unsignedBigInteger('labo_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('labo_equipement_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labo_equipements');
    }
};
