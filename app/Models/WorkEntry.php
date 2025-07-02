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
        'mission_id',
        'predefined_task_id',
        'logged_date',
        'hours',
        'comments',
    ];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id')
            ->whereHas('roles', fn($q) => $q->where('name', 'worker'));
    }
    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id');
    }
    public function predefinedTask()
    {
        return $this->belongsTo(PredefinedTasks::class, 'predefined_task_id');
    }
}
