<?php

namespace App\Models;

use App\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionTask extends Model
{
    /** @use HasFactory<\Database\Factories\MissionTaskFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mission_id',
        'task_type_id',
        'assigned_worker_id', // User ID of the worker assigned to the task
        'due_date',
        'status',
        'priority',
        'description',
        'estimated_hours', // Estimated hours to complete the task
        'actual_hours', // Actual hours spent on the task
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    /**
     * Get the mission associated with the task.
     */
    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id');
    }
    /**
     * Get the task type associated with the mission task.
     */
    public function taskType()
    {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

    /**
     * Get the worker assigned to the task.
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id')
            ->whereHas('roles', fn($q) => $q->where('name', 'worker'));
    }

    /**
     * Get the work entries associated with the mission task.
     */
    public function workEntries()
    {
        return $this->hasMany(WorkEntry::class, 'mission_task_id');
    }

    /**
     * Get the comments associated with the mission task.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'mission_task_id');
    }
}
