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

    protected $fillable = ['project_id', 'title', 'start_date', 'end_date', 'report_by', 'assigned_to', 'task_status_id', 'task_priority_id', 
        'task_type_id', 'kanban_list_rank', 'description', 'status', 'user_id', 'text', 'parent', 'level', 'list_order', 'is_starred', 
        'path', 'original_id'];

    protected $casts = ['start_date'=>'datetime:d-M-Y', 
                        'end_date'=>'datetime:d-M-Y'];


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

    public function getAssignedTo()
    {
        return DB::table('users')
                ->where('id', '=', $this->assigned_to)
                ->first();
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

    public function getTaskStatus()
    {
        return DB::table('task_statuses')
                ->where('id', '=', $this->task_status_id)
                ->first();
    }

    public function taskPriority(): BelongsTo
    {
        return $this->belongsTo(TaskPriority::class);
    }

    public function getTaskPriority()
    {
        return DB::table('task_priorities')
            ->where('id', '=', $this->task_priority_id)
            ->first();
    }
    
    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent');
    }

    public function getDescendants()
    {
        $descendants = collect(); 

        foreach ($this->children as $child) { 
            $descendants->push($child); 
            $descendants = $descendants->merge($child->getDescendants()); 
        }

        return $descendants;
    }

    public function ancestors()
    {
        $ancestors = collect();

        $parent = $this->getParent; 
        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->getParent;
        }

        return $ancestors;
    }

    /**
     * The tags that belong to the task.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_tasks');
    }

    public function getTaskTags()
    {
        return DB::table('tags')
            ->join('tag_tasks', 'tags.id', '=', 'tag_tasks.tag_id')
            ->where('tag_tasks.task_id', $this->id)
            ->select('tags.*')
            ->get();
    }

    public static function scopeFilterByStatus($query, $status_id, $project_id = null)
    {
        if ($project_id) {
            return $query->where('task_status_id', '=', $status_id)
                ->where('project_id', '=', $project_id)
                ->orderBy('kanban_list_rank', 'asc');
        }
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

    public function scopeWithAncestors($query, $criteria)
    {
        // Apply the filtering criteria
        $filteredTasks = $this->where($criteria)->get();

        // Collect all ancestors for the filtered tasks
        $allTasks = $filteredTasks->flatMap(function ($task) {
            return $task->ancestors()->push($task);
        });

        // Return unique tasks (to avoid duplicates)
        $uniqueTaskIds = $allTasks->pluck('id')->unique();

        return $query->whereIn('id', $uniqueTaskIds);
    }

    public static function sortedTasks($criteria = [], $sortField = 'path', $direction = 'asc', int $ancestorId = null)
    {
        $hasWhereClause = false;
        $bindings = [];
        $baseQuery = "
            WITH RECURSIVE task_hierarchy AS (
            SELECT tasks.*
            FROM tasks
        ";

        if (!empty($criteria)) {
            foreach ($criteria as $condition) {
                if ($condition['type'] === 'where') {
                    if (!$hasWhereClause) {
                        $baseQuery .= " WHERE tasks.{$condition['column']} ";
                        $hasWhereClause = true;
                    } else {
                        $baseQuery .= " AND tasks.{$condition['column']} ";
                    }
                    $operator = isset($condition['operator']) ? $condition['operator'] : '=';
                    $baseQuery .= "$operator ?";
                    $bindings[] = $condition['value'];
                } elseif ($condition['type'] === 'whereIn') {
                    if (!$hasWhereClause) {
                        $baseQuery .= " WHERE tasks.{$condition['column']} ";
                        $hasWhereClause = true;
                    } else {
                        $baseQuery .= " AND tasks.{$condition['column']} ";
                    }
            
                    $placeholders = implode(',', array_fill(0, count($condition['values']), '?'));
                    $baseQuery .= "IN ($placeholders)";
                    $bindings = array_merge($bindings, $condition['values']);
                } elseif ($condition['type'] === 'orWhere') {
                    if ($hasWhereClause) {
                        $baseQuery .= " OR tasks.{$condition['column']} ";
                    } else {
                        $baseQuery .= " WHERE tasks.{$condition['column']} ";
                        $hasWhereClause = true;
                    }
            
                    $operator = isset($condition['operator']) ? $condition['operator'] : '=';
                    $baseQuery .= "$operator ?";
                    $bindings[] = $condition['value'];
                } elseif ($condition['type'] === 'whereRaw') {
                    if (!$hasWhereClause) {
                        $baseQuery .= " WHERE ({$condition['column']}) ";
                        $hasWhereClause = true;
                    } else {
                        $baseQuery .= " AND ({$condition['column']}) ";
                    }
                    $bindings = array_merge($bindings, $condition['values']);
                }
            }
        }
        
        $baseQuery .= "
                UNION ALL
                SELECT t.*
                FROM tasks t
                INNER JOIN task_hierarchy th ON t.id = th.parent
                
            )
            SELECT DISTINCT * FROM task_hierarchy
        ";
        
        // Add ancestor filter if ancestorId is provided
        if ($ancestorId) {
            $task = Task::find($ancestorId);

            if ($task) {
                $ancestorDescendants = $task->getDescendants()->pluck('id')->toArray(); 
                array_push($ancestorDescendants, $ancestorId);
                if (!empty($ancestorDescendants)) {
                    $placeholders = implode(',', array_fill(0, count($ancestorDescendants), '?'));
                    $baseQuery .= " WHERE id IN ($placeholders)";
                    $bindings = array_merge($bindings, $ancestorDescendants);
                }
            }
        } 

        // $baseQuery .= " ORDER BY $sortField $direction;";

        $tasksData = DB::select($baseQuery, $bindings);
        $taskIds = array_map(fn($task) => $task->id, $tasksData);
        
        $tasks =  Task::whereIn('id', $taskIds)->orderBy($sortField, $direction)->get();

        // $tasks = collect();

        // foreach ($tasksData as $taskData) {
        //     $attributes = (array) $taskData;
        //     $task = new Task();
        //     $task->forceFill($attributes);
        //     $task->exists = true;
        //     $tasks->push($task);
        // }
        return $tasks;
    }

    public function scopeWithAncestorsCTE($query, $criteria)
    {
        $query->fromSub(function ($subQuery) use ($criteria) {
            $subQuery
                ->from('tasks')
                ->selectRaw('tasks.*, recursive_ancestors.id AS ancestor_id')
                ->join('tasks AS recursive_ancestors', 'tasks.parent', '=', 'recursive_ancestors.id')
                ->where($criteria);
        }, 'filtered_tasks');
    }

}
