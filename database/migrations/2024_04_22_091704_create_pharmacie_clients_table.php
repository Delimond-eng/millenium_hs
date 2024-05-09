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
        Schema::create('pharmacie_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_nom')->nullable();
            $table->string('client_phone');
            $table->unsignedBigInteger('pharmacie_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('client_created_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacie_clients');
    }
};
