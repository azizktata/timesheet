<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the worker's work entries.
     */
    public function workEntries()
    {
        return $this->hasMany(WorkEntry::class, 'worker_id')
            ->whereHas('worker', fn($q) => $q->where('name', 'worker'));
    }
    /**
     * Get the worker's plannings.
     */
    public function plannings()
    {
        return $this->hasMany(Planning::class, 'worker_id')
            ->whereHas('worker', fn($q) => $q->where('name', 'worker'));
    }
    /**
     * Get the worker's missions.
     */
    public function missions()
    {
        return $this->hasMany(Member::class, 'worker_id')->wheresHas('worker', function ($query) {
            $query->where('name', 'worker');
        })
            ->with('mission')
            ->whereHas('mission')
            ->get();
    }
}
