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
        Schema::create('transfert_patients', function (Blueprint $table) {
            $table->id();
            $table->string('transfert_hopital');
            $table->text('transfert_motif');
            $table->timestamp('transfert_date')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->timestamp('transfert_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfert_patients');
    }
};
