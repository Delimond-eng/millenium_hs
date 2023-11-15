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
            $table->integer('consult_detail_id', true);
            $table->string('consult_detail_libelle');
            $table->string('consult_detail_valeur');
            $table->text('consult_detail_obs');
            $table->timestamp('consult_detail_create_At')->useCurrent();
            $table->string('consult_detail_status', 10)->default('actif');
            $table->integer('consult_id');

            $table->foreign('consult_id')->references('consut_id')->on('consultations')->onDelete('cascade');
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