<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model
{
    /** @use HasFactory<\Database\Factories\MissionFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'reference',
        'start_date',
        'end_date',
        'manager_id',
        'status',
        'estimated_hours',
        'estimated_cost',
        'client_id',
        // 'strucure_id',
    ];

    /**
     * Get the manager of the mission.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id')
            ->whereHas('roles', fn($q) => $q->where('name', 'manager'));
    }
    /**
     * Get the members of the mission.
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'mission_id');
    }
    /**
     * Get the work entries of the mission.
     */
    public function workEntries()
    {
        return $this->hasMany(WorkEntry::class, 'mission_id');
    }
    /**
     * Get the plannings of the mission.
     */
    public function plannings()
    {
        return $this->hasMany(Planning::class, 'mission_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
