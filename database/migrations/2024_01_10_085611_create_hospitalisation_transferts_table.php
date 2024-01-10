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
        Schema::create('hospitalisation_transferts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('transfert_date_heure')->nullable();
            $table->text('transfert_raison')->nullable();
            $table->timestamp('transfert_created_At')->useCurrent();
            $table->unsignedBigInteger('hospitalisation_id');
            $table->unsignedBigInteger('lit_origine_id');
            $table->unsignedBigInteger('lit_destination_id');
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
        Schema::dropIfExists('hospitalisation_transferts');
    }
};
