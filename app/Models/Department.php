<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the missions associated with the department.
     * pivot table: department_mission
     */
    public function missions()
    {
        return $this->belongsToMany(Mission::class, 'department_mission', 'department_id', 'mission_id')
            ->withTimestamps();
    }
    /**
     * Get the predefined tasks associated with the department.
     */
    public function taskTypes()
    {
        return $this->hasMany(TaskType::class, 'department_id');
    }
}
