<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('produit_libelle')->unique();
            $table->string('produit_code')->unique();
            $table->string('produit_prix_unitaire');
            $table->integer('produit_stock_min')->default(10);
            $table->text('produit_description')->nullable();
            $table->timestamp('produit_created_At')->useCurrent();
            $table->unsignedBigInteger('categorie_id');
            $table->unsignedBigInteger('unite_id');
            $table->unsignedBigInteger('type_id');
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
        Schema::dropIfExists('medicaments');
    }
};
