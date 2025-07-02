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
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_id')->constrained('missions')->onDelete('cascade');
            $table->foreignId('worker_id')->constrained('users')->onDelete('cascade');
            $table->date('planned_date'); // Date for the planning entry
            // $table->time('start_time'); // Start time for the planning entry
            // $table->time('end_time'); // End time for the planning entry
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending'); // Status of the planning entry
            $table->text('notes')->nullable(); // Additional notes or comments about the planning entry
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal'); // e.g., low, normal, high
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plannings');
    }
};
