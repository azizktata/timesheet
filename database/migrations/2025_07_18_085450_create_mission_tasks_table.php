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
            $table->foreignId('mission_id')->constrained('missions');
            $table->foreignId('predefined_task_id')->constrained('predefined_tasks');
            $table->foreignId('worker_id')->constrained('users');

            $table->date('due_date');
            $table->enum('status', ['À Faire', 'En Cours', 'Terminé', 'En Attente', 'Annulé'])->default('À Faire');
            $table->enum('priority', ['basse', 'normale', 'élevée'])->default('normale');
            $table->text('descriptions')->nullable();
            $table->string('estimated_hours')->nullable();
            $table->string('actual_hours')->nullable();

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
