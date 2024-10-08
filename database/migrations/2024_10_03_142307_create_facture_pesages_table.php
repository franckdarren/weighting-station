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
        Schema::create('facture_pesages', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('type');
            $table->integer('forfait_usage');
            $table->integer('montant_total');
            $table->string('statut')->default('En attente de paiement');

            $table->foreignId('bon_pesee_id')->constrained()->onDelete('cascade');
            $table->foreignId('pv_id')->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quittance_pesages');
    }
};
