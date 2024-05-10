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
        Schema::create('pharmacist_sessions', function (Blueprint $table) {
            $table->id();
            $table->decimal('initial_balance')->default(0);
            $table->decimal('closing_balance')->default(0);
            $table->integer('nbre_ticket')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pharmacie_id');
            $table->time('started_at')->nullable();
            $table->time('end_at')->nullable();
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
        Schema::dropIfExists('pharmacist_sessions');
    }
};
