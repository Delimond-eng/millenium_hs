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
        Schema::create('pharmacie_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code');
            $table->integer('ticket_nb_items');
            $table->decimal('ticket_paiement');
            $table->string('ticket_devise')->default('CDF');
            $table->string('ticket_status')->default('actif');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pharmacie_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacie_tickets');
    }
};
