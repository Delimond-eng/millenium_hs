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
        Schema::create('pharmacie_operations', function (Blueprint $table) {
            $table->id();
            $table->integer('operation_qte');
            $table->string('operation_libelle');
            $table->string('operation_obs')->nullable();
            $table->string('operation_status')->default('actif');
            $table->unsignedBigInteger('produit_id');
            $table->decimal('produit_prix')->nullable();
            $table->string('produit_prix_devise')->default('CDF');
            $table->unsignedBigInteger('pharmacie_id');
            $table->unsignedBigInteger('pharmacie_dest_id')->nullable();
            $table->unsignedBigInteger('fournisseur_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('operation_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacie_operations');
    }
};
