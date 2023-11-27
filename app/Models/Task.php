<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;

class Task extends Model
{
    use HasFactory, Commentable;

    protected $fillable = ['project_id', 'title', 'start_date', 'planned_end_date',
        'description', 'status', 'user_id', 'text', 'type', 'parent', 'level', 'list_order'];

    protected $casts = ['start_date'=>'datetime:d-m-Y'];


    public function getOpenAttribute()
    {
        return true;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getParent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'report_by');
    }

    public function taskType(): BelongsTo
    {
        return $this->belongsTo(TaskType::class);
    }

    public function taskStatus(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function task_priority(): BelongsTo
    {
        return $this->belongsTo(TaskPriority::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent');
    }

    public function descendantTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent')->with('children');
    }

    /**
     * The tags that belong to the task.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_tasks');
    }

    public static function scopeFilterByStatus($query, $status_id)
    {
        return $query->where('task_status_id', '=', $status_id)->orderBy('kanban_list_rank', 'asc');
    }

    public static function scopeFilterByParent($query, $parent_id)
    {
        return $query->where('parent', '=', $parent_id)->orderBy('list_order', 'asc')->get();
    }

    public static function getBeyondRank($status_id, $rank)
    {
        return DB::table('tasks')
                ->where('task_status_id', '=', $status_id)
                ->where('kanban_list_rank', '>=', $rank)
                ->orderBy('kanban_list_rank', 'asc')
                ->get();
    }

    public function getNumberOfComments()
    {
        return DB::table('comments')
                ->where('commentable_id', '=', $this->id)
                ->where('parent_id', '=', null)
                ->where('deleted_at', '=', null)
                ->get()->count();
    }

}
