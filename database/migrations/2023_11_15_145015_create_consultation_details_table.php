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
        if(! Schema::hasTable("consultation_details")){
            Schema::create('consultation_details', function (Blueprint $table) {
                $table->id();
                $table->string('consult_detail_libelle');
                $table->string('consult_detail_valeur');
                $table->text('consult_detail_obs');
                $table->timestamp('consult_detail_create_At')->useCurrent();
                $table->string('consult_detail_status', 10)->default('actif');
                $table->unsignedBigInteger('consult_id');
            });
        }

        /* Schema::table('consultation_details', function (Blueprint $table) {
            $table->foreignId('consult_id')->constrained('consultations')->cascadeOnDelete()->cascadeOnUpdate();
        }); */
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