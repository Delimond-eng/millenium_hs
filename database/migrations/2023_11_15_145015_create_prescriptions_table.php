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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prescription_traitement_freq');
            $table->string('prescription_traitement_posologie');
            $table->string('prescription_traitement_duree');
            $table->timestamp('prescription_create_At')->useCurrent();
            $table->string('prescription_status', 10)->default('actif');
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('consult_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
};
