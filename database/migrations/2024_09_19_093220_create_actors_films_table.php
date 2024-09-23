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
        Schema::create('actors_films', function (Blueprint $table) {
            $table->foreignId('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreignId('actor_id')->references('id')->on('actors')->onDelete('cascade');
            $table->primary(['film_id', 'actor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actors_films');
    }
};
