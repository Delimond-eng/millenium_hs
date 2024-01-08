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
        Schema::create('mouvement_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('mouvement_stock_type');
            $table->integer('mouvement_stock_qte');
            $table->string('mouvement_stock_bon_code')->nullable();
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('fournisseur_id')->nullable();
            $table->unsignedBigInteger('fournisseur_facture_code')->nullable();
            $table->unsignedBigInteger('pharmacie_id')->nullable();
            $table->timestamp('mouvement_stock_created_At')->useCurrent();
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
        Schema::dropIfExists('mouvement_stocks');
    }
};
