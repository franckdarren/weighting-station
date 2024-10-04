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
        Schema::create('type_vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->integer('limite_poids');
            $table->integer('tolerance_limite_poids');
            $table->integer('nb_essieux');
            $table->integer('nb_groupe_essieux');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_vehicules');
    }
};
