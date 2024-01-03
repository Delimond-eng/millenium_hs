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
        Schema::create('consultation_pediatriques', function (Blueprint $table) {
            $table->id();
            $table->string('poids_bebe');
            $table->string('taille_bebe');
            $table->string('temperature_bebe');
            $table->string('tension_art_bebe');
            $table->unsignedBigInteger('bebe_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('consult_pediatrique_created_At');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultation_pediatriques');
    }
};
