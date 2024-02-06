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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->string('paiement_libelle');
            $table->decimal('paiement_montant');
            $table->string('paiement_montant_devise');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('paiement_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
