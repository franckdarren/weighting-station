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
        Schema::create('quittance_pesages', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->integer('duree_operation');
            $table->integer('tarif');

            $table->foreignId('bon_pesee_id')->constrained()->onDelete('cascade');
            $table->foreignId('pv_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('facture_immobilisation_id')->nullable()->constrained()->onDelete('cascade');

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
