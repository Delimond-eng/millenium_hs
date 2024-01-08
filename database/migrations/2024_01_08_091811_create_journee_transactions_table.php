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
        Schema::create('journee_transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('journee_opening_montant');
            $table->decimal('journee_closing_montant')->nullable();
            $table->timestamp('journee_opening_At')->useCurrent();
            $table->timestamp('journee_closed_At')->nullable();
            $table->integer('journee_sell_count')->default(0);
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('pharmacie_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journee_transactions');
    }
};
