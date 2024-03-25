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
        Schema::create('produit_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('produit_prix');
            $table->string('produit_prix_devise')->default("CDF");
            $table->timestamp('produit_prix_create_At')->useCurrent();
            $table->unsignedBigInteger('pharmacie_id');
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('hopital_id');
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
        Schema::dropIfExists('produit_prices');
    }
};
