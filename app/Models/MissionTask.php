<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionTask extends Model
{
    /** @use HasFactory<\Database\Factories\MissionTaskFactory> */
    use HasFactory;

    protected $fillable = [
        'mission_id',
        'predefined_task_id',
        'worker_id', // User ID of the worker assigned to the task
        'due_date',
        'status',
        'priority',
        'description',
        'estimated_hours', // Estimated hours to complete the task
        'actual_hours', // Actual hours spent on the task
    ];

    /**
     * Get the mission associated with the task.
     */
    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id');
    }
    /**
     * Get the predefined task associated with the mission task.
     */
    public function predefinedTask()
    {
        return $this->belongsTo(PredefinedTasks::class, 'predefined_task_id');
    }

    /**
     * Get the worker assigned to the task.
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id')
            ->whereHas('roles', fn($q) => $q->where('name', 'worker'));
    }
}
