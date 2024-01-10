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
        Schema::create('hospitalisations', function (Blueprint $table) {
            $table->id();
            $table->timestamp('hospitalisation_start_At')->nullable();
            $table->timestamp('hospitalisation_end_At')->nullable();
            $table->text('hospitalisation_raison_admission');
            $table->unsignedBigInteger('lit_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('service_responsable_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('hospitalisation_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospitalisations');
    }
};
