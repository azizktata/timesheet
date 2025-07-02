<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planning extends Model
{
    /** @use HasFactory<\Database\Factories\PlanningFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'worker_id',
        'mission_id',
        'predefined_task_id',
        'planned_date',
        'status',
        'priority',
        'notes'
    ];
}
