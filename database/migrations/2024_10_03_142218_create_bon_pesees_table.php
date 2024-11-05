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
            $table->float('vitesse');
            $table->string('plaque_immatriculation')->nullable();
            $table->string('entreprise')->nullable();
            $table->string('produits_transportes')->nullable();

            $table->string('description')->nullable();

            // $table->string('destination');
            // $table->integer('lineaire_parcouru');
            // $table->integer('lineaire_restant');
            $table->integer('poids')->nullable();
            $table->integer('surchage')->nullable();

            $table->integer('poids_E1')->nullable();
            $table->integer('poids_E2')->nullable();
            $table->integer('poids_E3')->nullable();
            $table->integer('poids_E4')->nullable();
            $table->integer('poids_E5')->nullable();
            $table->integer('poids_E6')->nullable();
            $table->integer('poids_E7')->nullable();




            // $table->foreignId('vehicule_id')->constrained()->onDelete('cascade');
            // $table->foreignId('conducteur_id')->constrained()->onDelete('cascade');


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
