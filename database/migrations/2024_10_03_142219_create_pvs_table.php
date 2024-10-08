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
        Schema::create('pvs', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->string('surchage_e1')->nullable();
            $table->string('surchage_e2')->nullable();
            $table->string('surchage_e3')->nullable();
            $table->string('surchage_e4')->nullable();
            $table->string('surchage_e5')->nullable();
            $table->string('surchage_e6')->nullable();

            $table->string('amendes_surchage_e1')->nullable();
            $table->string('amendes_surchage_e2')->nullable();
            $table->string('amendes_surchage_e3')->nullable();
            $table->string('amendes_surchage_e4')->nullable();
            $table->string('amendes_surchage_e5')->nullable();
            $table->string('amendes_surchage_e6')->nullable();

            $table->string('montant_amendes')->nullable();


            $table->foreignId('bon_pesee_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pvs');
    }
};
