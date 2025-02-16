<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Exception;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

trait TaskTrait
{
    public $tasks;

    public function filterSortTasksWithHierarchy($criteria = [], $sortField = 'path', $direction = 'asc', int $ancestorId = null)
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

        $tasksData = DB::select($baseQuery, $bindings);
        $taskIds = array_map(fn($task) => $task->id, $tasksData);
        
        $tasks =  Task::whereIn('id', $taskIds)->orderBy($sortField, $direction)->get();

        return $tasks;
    }

    public function filterTasks($filterParams, $sortField = 'path', $direction = 'asc')
    {
        
        $criteria = $this->getCriteria($filterParams);
        logger($criteria);
        $query = Task::query();
        if(empty($criteria)){
            return null;
        }
        foreach ($criteria as $condition) {
            $type = $condition['type'];
            $column = $condition['column'];
            $operator = $condition['operator'] ?? null;
            $value = $condition['value'] ?? null;
    
            switch ($type) {
                case 'where':
                    $query->where($column, $operator ?? '=', $value);
                    break;
                case 'whereIn':
                    $query->whereIn($column, $value);
                    break;
                case 'whereNotIn':
                    $query->whereNotIn($column, $value);
                    break;
                case 'whereBetween':
                    $query->whereBetween($column, $value);
                    break;
                case 'whereNull':
                    $query->whereNull($column);
                    break;
                case 'whereNotNull':
                    $query->whereNotNull($column);
                    break;
                case 'whereDate':
                    $query->whereDate($column, $operator, $value);
                    break;
                case 'whereMonth':
                    $query->whereMonth($column, $value);
                    break;
                case 'whereYear':
                    $query->whereYear($column, $value);
                    break;
                case 'whereTime':
                    $query->whereTime($column, $operator, $value);
                    break;
                case 'whereColumn':
                    $query->whereColumn($column, $operator, $value);
                    break;
                default:
                    throw new Exception("Invalid condition type: {$type}");
            }
        }
        if($query){
            return $query->orderBy($sortField, $direction)->get();
        }
        return null;
    }

    private function getCriteria($filterParams)
    {
        $criteria = [];

        if ($filterParams['sidebarFilter'] != null) {
            foreach ($filterParams['sidebarFilter'] as  $condition) {
                    array_push($criteria, $condition);
            }
        }

        if ($filterParams['searchTerm'] != null) {
            array_push($criteria, [
                'type' => 'where',
                'column' => DB::raw("LOWER(tasks.title)"),
                'operator' => 'LIKE',
                'value' => '%' . strtolower($filterParams['searchTerm']) . '%'
            ]);
        }

        if ($filterParams['fTitle'] != null) {
            array_push($criteria, [
                'type' => 'where',
                'column' => DB::raw("LOWER(tasks.title)"),
                'operator' => 'LIKE',
                'value' => '%' . strtolower($filterParams['fTitle']) . '%'
            ]);
        }
        
        $fStatus = array_filter(
            $filterParams['fStatus'],
            fn($value, $key) => $value, 
            ARRAY_FILTER_USE_BOTH
        );
        
        logger($filterParams['fPhase']);
        if (!empty($filterParams['fPhase'])) {
            array_push($criteria, ['type' => 'where', 'column' => 'path', 'operator'=> '~', 'value' => $filterParams['fPhase'] . '.*'] );
        }

        if (!empty($fStatus)) {
            array_push($criteria, ['type' => 'whereIn', 'column' => 'task_status_id', 'values' => array_keys($fStatus)]);
        }
        
        if ($filterParams['fDateFrom'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'end_date', 'operator'=> '>=', 'value' => $filterParams['fDateFrom']]);
                
        }

        if ($filterParams['fDateTo'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'end_date', 'operator'=> '<=', 'value' => $filterParams['fDateTo']]);
                
        }

        if ($filterParams['fPriority'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'task_priority_id', 'value' => $filterParams['fPriority']]);  
        }

        if ($filterParams['fAssignee'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'assigned_to', 'value' => $filterParams['fAssignee']]);  
        }

        if ($filterParams['fTaskIds'] != null) {
            array_push($criteria, ['type' => 'whereIn', 'column' => 'id', 'values' => $filterParams['fTaskIds']]);  
        }
        return $criteria;   
    }
}
