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
        Schema::create('hospitalisation_lits', function (Blueprint $table) {
            $table->id();
            $table->string('lit_numero');
            $table->string('lit_status')->default('disponible');
            $table->timestamp('lit_create_At')->useCurrent();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('type_id');
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
        Schema::dropIfExists('hospitalisation_lits');
    }
};
