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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // ID of the user who made the comment
            $table->text('content'); // Content of the comment
            $table->foreignId('mission_task_id')->constrained('mission_tasks')->onDelete('cascade'); // ID of the mission task this comment is associated with
            $table->boolean('is_important')->default(false); // Boolean to mark if the comment is important
            $table->softDeletes(); // Soft delete column for the comment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
