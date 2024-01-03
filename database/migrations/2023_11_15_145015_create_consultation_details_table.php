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
        Schema::create('consultation_details', function (Blueprint $table) {
            $table->id();
            $table->string('consult_detail_libelle');
            $table->string('consult_detail_valeur');
            $table->timestamp('consult_detail_create_At')->useCurrent();
            $table->string('consult_detail_status', 10)->default('actif');
            $table->unsignedBigInteger('consult_id');
            $table->unsignedBigInteger('hopital_id');
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
        Schema::dropIfExists('consultation_details');
    }
};
