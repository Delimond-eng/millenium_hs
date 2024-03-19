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
        Schema::create('produit_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_libelle');
            $table->string('type_description')->nullable();
            $table->unsignedBigInteger('pharmacie_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('type_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produit_types');
    }
};
