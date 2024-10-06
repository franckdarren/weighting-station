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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('plaque_immatriculation');
            $table->string('carte_grise');
            $table->string('statut');
            $table->string('nom_proprietaire');
            $table->string('entreprise')->nullable();
            $table->boolean('en_convoi');
            $table->integer('nb_vehicule')->nullable();

            $table->foreignId('type_vehicule_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehycules');
    }
};
