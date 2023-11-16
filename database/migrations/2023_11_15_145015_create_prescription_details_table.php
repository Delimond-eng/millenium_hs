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
        Schema::create('prescription_details', function (Blueprint $table) {
            $table->integer('prescreption_detail_id', true);
            $table->string('prescription_detail_libelle');
            $table->string('prescription_detail_valeur');
            $table->text('prescrption_detail_obs');
            $table->integer('prescription_id');
            $table->timestamp('prescription_detail_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->string('prescription_detail_status')->default('actif');
            $table->foreign('prescription_id')->references('prescription_id')->on('prescriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_details');
    }
};