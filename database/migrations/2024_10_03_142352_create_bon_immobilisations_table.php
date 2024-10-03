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
        Schema::create('bon_immobilisations', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->date('date_entree');
            $table->integer('duree');
            $table->string('emplacement');

            // Client A Saisir
            $table->string('nom_prenoms_client');
            $table->string('nature_piece_identite');
            $table->string('numero_piece_identite');
            $table->date('date_validite_piece_identite');

            $table->foreignId('pv_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_immobilisations');
    }
};
