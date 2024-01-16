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
        Schema::create('facturation_configs', function (Blueprint $table) {
            $table->id();
            $table->string('facturation_config_libelle');
            $table->decimal('facturation_config_montant');
            $table->string('facturation_config_montant_devise');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->timestamp('facturation_config_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturation_configs');
    }
};
