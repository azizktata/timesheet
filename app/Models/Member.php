<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'mission_id',
        'worker_id',
        'role',
        'joined_at',
        'left_at',
        'hourly_rate'
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
}
