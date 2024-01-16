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
        Schema::create('premier_soins', function (Blueprint $table) {
            $table->id();
            $table->timestamp('premier_soin_date_heure')->nullable();
            $table->timestamp('premier_soin_created_At')->useCurrent();
            $table->text('premier_soin_motif');
            $table->text('premier_soin_obs')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('hopital_emplacement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premier_soins');
    }
};
