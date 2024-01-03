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
        Schema::create('hopital_emplacements', function (Blueprint $table) {
            $table->id();
            $table->string('hopital_emplacement_libelle');
            $table->string('hopital_emplacement_adresse');
            $table->timestamp('hopital_emplacement_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('created_by')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hopital_emplacements');
    }
};
