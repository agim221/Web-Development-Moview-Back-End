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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->text('description');

            $table->foreignId('release_date')->nullable()->references('year')->on('years')->onDelete('set null');
            $table->float('rating');
            $table->foreignId('country_id')->nullable()->references('id')->on('countries')->onDelete('set null');

            $table->integer('status');
            $table->string('trailer');
            $table->string('availability');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
