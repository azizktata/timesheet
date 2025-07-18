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
        Schema::create('mission_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('mission_id')->constrained('missions');
            $table->foreignId('task_type_id')->constrained('task_types');
            $table->foreignId('assigned_worker_id')->constrained('users');

            $table->date('due_date');
            $table->enum('status', ['À Faire', 'En Cours',  'En Attente', 'En Revue', 'Terminé', 'En Retard'])->default('À Faire');
            $table->enum('priority', ['basse', 'normale', 'élevée'])->default('normale');
            $table->text('description')->nullable();
            $table->decimal('estimated_hours', 5, 2)->nullable();
            $table->decimal('actual_hours', 5, 2)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_tasks');
    }
};
