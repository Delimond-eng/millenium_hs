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
        Schema::create('echographies', function (Blueprint $table) {
            $table->id();
            $table->text("echographie_resultats");
            $table->unsignedBigInteger("suivi_grossesse_id")->default(0);
            $table->unsignedBigInteger("patient_id")->default(0);
            $table->timestamp('echographie_created_At')->useCurrent();
            $table->unsignedBigInteger('hopital_id');
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
        Schema::dropIfExists('echographies');
    }
};
