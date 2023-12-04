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
        if(!Schema::hasTable("prescriptions")){
            Schema::create('prescriptions', function (Blueprint $table) {
                $table->id();
                $table->string('prescription_traitement');
                $table->string('prescription_posologie');
                $table->string('prescription_traitement_type');
                $table->timestamp('prescription_create_At')->useCurrent();
                $table->string('prescription_status', 10)->default('actif');
                $table->unsignedBigInteger('consult_id');
                $table->unsignedBigInteger('hopital_emplacement_id');
                $table->unsignedBigInteger('hopital_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
};
