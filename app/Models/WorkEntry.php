<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkEntry extends Model
{
    /** @use HasFactory<\Database\Factories\WorkEntryFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'worker_id',

        'mission_task_id',
        // 'predefined_task_id',
        'entry_date',
        'hours_worked', // Changed from 'hours' to 'hours_worked'
        'description'
        // 'comments', // Commented out as per the context
    ];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id')
            ->whereHas('roles', fn($q) => $q->where('name', 'worker'));
    }

    public function missionTask()
    {
        return $this->belongsTo(MissionTask::class, 'mission_task_id');
    }
}
