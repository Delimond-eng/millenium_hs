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
                $table->string('prescription_libelle');
                $table->timestamp('prescription_create_At')->useCurrent();
                $table->string('prescrption_status', 10)->default('actif');
                $table->unsignedBigInteger('patient_id');
                $table->unsignedBigInteger('agent_id');
            });
        }

        /* Schema::create('prescriptions', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete()->cascadeOnUpdate();
        }); */
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