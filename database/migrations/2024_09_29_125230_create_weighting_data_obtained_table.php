<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('weighting_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('weighing1ID')->nullable();
            $table->string('vehicleID')->nullable();
            $table->string('plateFront')->nullable();
            $table->string('plateBack')->nullable();
            $table->uuid('vehicleType')->nullable();
            $table->string('vehicleTypeOrdering')->nullable();
            $table->time('date')->nullable();
            $table->float('totalWeight')->nullable();
            $table->float('overload')->nullable();
            $table->string('companyID')->nullable();
            $table->string('companyName')->nullable();
            $table->string('materialID')->nullable();
            $table->string('materialName')->nullable();
            $table->uuid('scaleID')->nullable();
            $table->uuid('userID')->nullable();
            $table->boolean('sync')->nullable();
            $table->integer('scaleType')->nullable();
            $table->boolean('isDeleted')->nullable();
            $table->uuid('weighingDimensionId')->nullable();
            $table->integer('weighingNo')->nullable();
            $table->boolean('unetSent')->nullable();
            $table->float('totalWeightLimit')->nullable();
            $table->float('totalWeightLimitTolerance')->nullable();
            $table->float('emptyWeight')->nullable();
            $table->float('speed')->nullable();
            $table->boolean('isUnetSent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};