<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bon_pesees', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->string('produits_transportes');
            $table->string('provenance');
            $table->string('destination');
            $table->integer('lineaire_parcouru');
            $table->integer('lineaire_restant');
            $table->integer('poids');
            $table->integer('surchage');
            $table->float('vitesse');

            $table->integer('poids_E1')->nullable();
            $table->integer('poids_E2')->nullable();
            $table->integer('poids_E3')->nullable();
            $table->integer('poids_E4')->nullable();
            $table->integer('poids_E5')->nullable();
            $table->integer('poids_E6')->nullable();



            $table->foreignId('vehicule_id')->constrained()->onDelete('cascade');
            $table->foreignId('conducteur_id')->constrained()->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_pesees');
    }
};
