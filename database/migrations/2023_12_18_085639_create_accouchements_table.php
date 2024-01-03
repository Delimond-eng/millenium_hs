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
        Schema::create('accouchements', function (Blueprint $table) {
            $table->id();
            $table->string('accouchement_type');
            $table->string('accouchement_nbre_bebe')->default("1");
            $table->timestamp('accouchement_date_heure');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('hopital_emplacement_id');
            $table->timestamp('accouchement_created_At')->useCurrent();
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
        Schema::dropIfExists('accouchements');
    }
};
