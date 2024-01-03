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
        Schema::create('naissances', function (Blueprint $table) {
            $table->id();
            $table->string('naissance_nom');
            $table->timestamp('naissance_date');
            $table->string('naissance_poids');
            $table->string('naissance_taille');
            $table->timestamp('naissance_created_At')->useCurrent();
            $table->unsignedBigInteger('hopital_id');
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
        Schema::dropIfExists('naissances');
    }
};
