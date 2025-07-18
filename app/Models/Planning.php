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
        'manager_id',
        'planned_date',
        'details'

    ];

    /**
     * Get the mission associated with the planning.
     */
    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id');
    }

    /**
     * Get the worker associated with the planning.
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    /**
     * Get the manager associated with the planning.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id')
            ->whereHas('roles', fn($q) => $q->where('name', 'manager'));
    }
}
