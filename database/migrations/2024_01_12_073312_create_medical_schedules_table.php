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
        Schema::create('medical_schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamp('schedule_date_heure')->nullable();
            $table->string('schedule_duree')->nullable();
            $table->text('schedule_note')->nullable();
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->timestamp('schedule_created_At')->useCurrent();
            $table->string('schedule_status')->default('actif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_schedules');
    }
};
