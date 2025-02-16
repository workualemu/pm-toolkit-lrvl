<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Project;

class TaskDateObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        if (isset($task->start_date)) {
            $this->setParentStartDate($task);
        }

        if (isset($task->end_date)) {
            $this->setParentEndDate($task);
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->isDirty('start_date') && isset($task->start_date)) {
            $this->setParentStartDate($task);
        }

        if ($task->isDirty('end_date') && isset($task->end_date)) {
            $this->setParentEndDate($task);
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        if (isset($task->start_date)) {
            $this->setParentStartDate($task, true);
        }

        if (isset($task->end_date)) {
            $this->setParentEndDate($task, true);
        }
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }

    //---------------------------------Private functions-----------------------------------------------------
    private function setParentStartDate($task, $isDelete = false){

        $earliestStartDate = $task->earliestSiblingStartDate();
        if(!$isDelete){ // if it is NOT a task delete operation
            $earliestStartDate = isset($earliestStartDate) && $earliestStartDate < $task->start_date ? $earliestStartDate : $task->start_date;
        }

        $parent = $task->getParent;
        if($parent){
            $parent->setAttribute('start_date', $earliestStartDate);
            $parent->save();
            return;
        }
        
        $project = Project::find($task->project_id);
        $project->start_date = $earliestStartDate;
        $project->save();
        return;
    }

    private function setParentEndDate($task, $isDelete = false){

        $latestEndDate = $task->latestSiblingEndDate();
        if(!$isDelete){ // if it is NOT a task delete operation
            $latestEndDate = isset($latestEndDate) && $latestEndDate > $task->end_date ? $latestEndDate : $task->end_date;
        }

        $parent = $task->getParent;
        if($parent){
            $parent->setAttribute('end_date', $latestEndDate);
            $parent->save();
            return;
        }
        $project = Project::find($task->project_id);
        $project->end_date = $latestEndDate;
        $project->save();
        return;
    }
}
