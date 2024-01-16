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
        Schema::create('parteners', function (Blueprint $table) {
            $table->id();
            $table->string('partener_nom');
            $table->string('partener_adresse');
            $table->string('partener_contact');
            $table->unsignedBigInteger('hopital_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('partener_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parteners');
    }
};
