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
            $table->id();
            $table->string('prescription_detail_libelle');
            $table->string('prescription_detail_valeur');
            $table->text('prescrption_detail_obs');
            $table->timestamp('prescription_detail_create_At')->useCurrentOnUpdate()->useCurrent();
            $table->string('prescription_detail_status')->default('actif');
            $table->unsignedBigInteger('prescription_id');
        });

        /* Schema::table('prescription_details', function (Blueprint $table) {
            $table->foreignId('prescription_id')->constrained('prescriptions')->cascadeOnDelete()->cascadeOnUpdate();
        }); */
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