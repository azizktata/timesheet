<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    /** @use HasFactory<\Database\Factories\StructureFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'type', // e.g., department, team, etc.
        // 'parent_id' // for hierarchical structures
    ];
}
