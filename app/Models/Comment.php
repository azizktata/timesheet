<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'content',
        'mission_task_id', // ID of the mission task this comment is associated with
        'is_important', // Boolean to mark if the comment is important
        'created_at', // Timestamp for when the comment was created
        'updated_at', // Timestamp for when the comment was last updated
    ];

    /**
     * Get the user who made the comment.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    /**
     * Get the mission task associated with the comment.
     */
    public function missionTask()
    {
        return $this->belongsTo(MissionTask::class, 'mission_task_id');
    }

    /**
     * Get the comments for a specific mission task.
     */
    public function scopeForMissionTask($query, $missionTaskId)
    {
        return $query->where('mission_task_id', $missionTaskId);
    }

    /**
     * Get the comments for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('author_id', $userId);
    }

    /**
     * Get the comments created within a specific date range.
     */
    public function scopeCreatedBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get the comments that contain a specific keyword in their content.
     */
    public function scopeContainingKeyword($query, $keyword)
    {
        return $query->where('content', 'like', '%' . $keyword . '%');
    }

    /**
     * Get the comments that are marked as important.
     */
    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    /**
     * Get the comments that are not marked as important.
     */
    public function scopeNotImportant($query)
    {
        return $query->where('is_important', false);
    }
}
