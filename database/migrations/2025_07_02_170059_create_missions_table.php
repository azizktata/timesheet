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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('reference')->unique()->nullable(); // Unique reference for the mission
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('manager_id')->constrained('users');
            $table->foreignId('client_id')->constrained('clients');
            $table->unsignedInteger('estimated_hours')->nullable(); // Estimated hours for the mission
            $table->decimal('estimated_cost', 10, 2)->nullable(); // Estimated
            $table->enum('status', ['Planifiée', 'En Cours', 'Terminée', 'Annulée'])->default('Planifiée');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
