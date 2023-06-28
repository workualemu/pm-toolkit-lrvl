<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'title', 'start_date', 'end_date', 'description', 'status', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
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

    /**
     * The tags that belong to the task.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public static function scopeFilterByStatus($query, $status_id){
        return $query->where('task_status_id', '=', $status_id)->orderBy('kanban_list_rank', 'asc');
    }

    public static function getBeyondRank($status_id, $rank){
        return DB::table('tasks')
                ->where('task_status_id', '=', $status_id)
                ->where('kanban_list_rank', '>=', $rank)
                ->orderBy('kanban_list_rank', 'asc')
                ->get();
    }
    // public static function scopeFilterByKanban($query,$kaban_id){
    //     return $query->whereHas('taskStatus',function($query) use ($kaban_id){
    //             return $query->where('kanban_list_id', '=', $kaban_id);
    //     });
    // }

}
