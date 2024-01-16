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
        Schema::create('premier_soin_traitements', function (Blueprint $table) {
            $table->id();
            $table->string('ps_traitement_libelle');
            $table->string('ps_traitement_type');
            $table->string('ps_traitement_dosage');
            $table->string('ps_traitement_unite');
            $table->string('premier_soin_id');
            $table->timestamp('ps_traitement_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premier_soin_traitements');
    }
};
