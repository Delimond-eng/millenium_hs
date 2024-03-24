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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('fournisseur_nom');
            $table->string('fournisseur_adresse');
            $table->string('fournisseur_email')->nullable();
            $table->string('fournisseur_telephone')->nullable();
            $table->timestamp('fournisseur_created_At')->useCurrent();
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
        Schema::dropIfExists('fournisseurs');
    }
};
