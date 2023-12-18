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
        Schema::create('visite_prenatales', function (Blueprint $table) {
            $table->id();
            $table->string('visite_poids');
            $table->string('visite_tension_art');
            $table->text('visite_recommandations');
            $table->unsignedBigInteger('suivi_grossesse_id');
            $table->timestamp('visite_created_At')->useCurrent();
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visite_prenatales');
    }
};
