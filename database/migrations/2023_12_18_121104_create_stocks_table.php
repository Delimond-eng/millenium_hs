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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('stock_code');
            $table->integer('stock_qte_dispo');
            $table->integer('stock_qte_min');
            $table->string('emplacement');
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('pharmacie_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('fournisseur_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('stock_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};
