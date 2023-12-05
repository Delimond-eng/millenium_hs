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
        Schema::create('consultation_symptomes', function (Blueprint $table) {
            $table->id();
            $table->string('consult_symptome_libelle');
            $table->unsignedBigInteger('consult_id');
            $table->timestamp('consult_symptome_create_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultation_symptomes');
    }
};
