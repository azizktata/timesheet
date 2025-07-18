<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PredefinedTasks extends Model
{
    /** @use HasFactory<\Database\Factories\PredefinedTasksFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'default_duration',
        'department_id',
        'active'
    ];
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
