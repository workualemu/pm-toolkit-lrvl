<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\Tag;
use App\Models\TaskStatus;
use App\Models\TaskPriority;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Carbon\Carbon;

class TemplateProjectsModal extends Component
{
    public Project $template;
    public $projects = [];
    public $showModal = false;
    public $readOnly = '';
    public $sourceProject = 0;

    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $status;

    private $taskPriorityMap = [];
    private $taskStatusMap = [];
    private $tagMap = [];

    #[On('openTemplateModal')]
    public function openTemplateModal($template_id)
    {
        if($template_id == null){
            $this->template = new Project();
        } else {
            $this->template = Project::find($template_id);
        }

        $this->hidrate();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $user = Auth::user();
        
        $this->dehidrate();

        $this->template->user_id = $user->id;

        $sourceProject = Project::find($this->sourceProject);
        if($sourceProject == null){
            $this->addError('sourceProject', 'The selected source project is invalid.');
            return;
        }
        $this->template->start_date = $sourceProject->start_date;
        $this->template->end_date = $sourceProject->end_date;
        $this->template->is_template = true;
        $this->template->status = $this->template->status == '' ? 'ACTIVE' : $this->template->status;
        $taskPriorityMap = [];
        $taskStatusMap = [];
        $tagMap = [];
        try{
            DB::beginTransaction();
            $this->template->save();
            $this->template->refresh();
    
            if(!$this->createTemplateFromSource($sourceProject, $user->id)){
                $this->error("Unexpected error happened");
                DB::rollBack();
                return;
            }
    
            $this->dispatch('refreshTemplate');
            $this->showModal = false;

            DB::commit();
        } catch (\Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");
            DB::rollBack();
        }
        
    }

    public function mount()
    {
        $this->template = new Project();
        $user =  Auth::user();
        if(!$user->hasRole('Project Manager')){
            // $this->readOnly = 'readonly';
        }

        $this->projects = Project::where('is_template', false)->get();
    }

    public function render()
    {
        return view('livewire.settings.template-projects-modal');
    }

    //--------------------- private methods ---------------------

    private function createTemplateFromSource(Project $source, $user_id) : bool
    {
        
        if(!$this->copyTagTemplateFromSource($source, $user_id) ){
            return false;
        }

        if(!$this->copyTaskPriorityTemplateFromSource($source, $user_id) ){
            return false;
        }
        if(!$this->copyTaskStatusTemplateFromSource($source, $user_id) ){
            return false;
        }
        if(!$this->copyReportsTemplateFromSource($source, $user_id) ){
            return false;
        }

       $phases = $source->getTasksByLevel(0);
       Task::where('project_id', $this->template->id)->delete();
       if(!$this->copyTemplateFromSource($phases, null, "", 0, $source, $user_id)){
            return false;
       }
        
        return true;
    }
    
    private function copyTemplateFromSource($tasks, $parent_id, $parentPath, $level, Project $source, $user_id): bool
    {
        if($source == null){
            return false;
        }
        
        foreach ($tasks as $task) {
            
            $statusValue = $task->getTaskStatus()?->value;
            $taskStatusId = $this->taskStatusMap[$statusValue] ?? null;
            $priorityValue = $task->getTaskPriority()?->value;
            $taskPriorityId = $this->taskPriorityMap[$priorityValue] ?? null;
            
            // $newTask = $task->replicate();
            
            $newTask = $task->replicate(); 
            $newTask->start_date = Carbon::parse($task->start_date)->format('Y-m-d H:i:s');
            $newTask->end_date = Carbon::parse($task->end_date)->format('Y-m-d H:i:s');
            logger($newTask);
            $newTask->task_status_id = $taskStatusId;
            $newTask->task_priority_id = $taskPriorityId;
            $newTask->user_id = $user_id;
            $newTask->project_id = $this->template->id;
            $newTask->parent = $parent_id;
            if(!$newTask->save()){
                return false;
            } 
            $newTask->refresh();

            $tagMap = $this->tagMap;
            $modifiedTagIds = $task->getTaskTags()->map(function ($tag) use ($tagMap) {
                $tag->newId = $tagMap[$tag->label];
                return $tag;
            });
            $savedTags = Tag::whereIn('id', $modifiedTagIds->pluck('newId'))->get();
            $newTask->tags()->sync($savedTags);
            $taskPath = $level == 0 ? $newTask->id : "{$parentPath}.{$newTask->id}";
            $newTask->path = $taskPath;
    
            if(!$newTask->save()){
                return false;
            } 
            $newTask->refresh();

            $children = $task->children;
            if($children){
                if(!$this->copyTemplateFromSource($children, $newTask->id, $taskPath, $level + 1, $source, $user_id)){
                    return false;
                }
            }
        }

        return true;
    }

    private function copyTagTemplateFromSource(Project $source, $user_id) : bool
    {
        logger("---------- Copying tags ---------------");
        if($source == null){
            return false;
        }
        Tag::where('project_id', $this->template->id)->delete();
        $sourceItems = $source->getTags();
        // ---------copy all source project items to the template project---------------
        foreach ($sourceItems as $tag) {
            $newTag = Tag::create([
                'label' => $tag->label,
                'description' => $tag->description,
                'color' => $tag->color,
                'user_id' => $user_id,
                'project_id' => $this->template->id
            ]);
            $this->tagMap[$tag->label] = $newTag->id;
        }

        return true;
    }

    private function copyTaskPriorityTemplateFromSource(Project $source, $user_id) : bool
    {
        logger("---------- Copying task priorities ---------------");
        if($source == null){
            return false;
        }
        TaskPriority::where('project_id', $this->template->id)->delete();
        // ---------copy all source project items to the template project---------------
        $sourceItems = $source->getTaskPriorities();
        foreach ($sourceItems as $priority) {
            $taskPriority = TaskPriority::create([
                'value' => $priority->value,
                'description' => $priority->description,
                'color' => $priority->color,
                'user_id' => $user_id,
                'project_id' => $this->template->id
            ]);

            $this->taskPriorityMap[$priority->value] = $taskPriority->id;
        }

        return true;
    }
    
    private function copyTaskStatusTemplateFromSource(Project $source, $user_id) : bool
    {
        logger("---------- Copying task statuses ---------------");
        if($source == null){
            return false;
        }
        
        TaskStatus::where('project_id', $this->template->id)->delete();
        $statuses = $source->getTaskStatuses();
        foreach ($statuses as $status) {
            $taskStatus = TaskStatus::create([
                'value' => $status->value,
                'description' => $status->description,
                'color' => $status->color,
                'kanban_list_rank' => $status->kanban_list_rank,
                'is_completing'=>$status->is_completing,
                'user_id' => $user_id,
                'project_id' => $this->template->id
            ]);

            $this->taskStatusMap[$status->value] = $taskStatus->id;
        }
        return true;
    }
    
    private function copyReportsTemplateFromSource(Project $source, $user_id) : bool
    {
        logger("---------- Copying reports ---------------");
        if($source == null){
            return false;
        }
        
        Report::where('project_id', $this->template->id)->delete();
        // ---------copy all source project items to the template project---------------
        $sourceItems = $source->reports;
        foreach ($sourceItems as $item) {
            $report = Report::create([
                'title' => $item->title,
                'description' => $item->description,
                'select_clause' => $item->select_clause,
                'from_clause' => $item->from_clause,
                'where_clause' => $item->where_clause,
                'order_clause' => $item->order_clause,
                'groupby_clause' => $item->groupby_clause,
                'having_clause' => $item->having_clause,
                'published' => $item->published,
                'show_meta' => $item->show_meta,
                'show_print_user' => $item->show_print_user,
                'show_print_date' => $item->show_print_date,
                'user_id' => $user_id,
                'project_id' => $this->template->id
            ]);
        }
        logger("---------- reports done ---------------");
        return true;
    }

    private function hidrate()
    {
        $this->title = $this->template->title;
        $this->description = $this->template->description;
        $this->start_date = $this->template->start_date;
        $this->end_date = $this->template->end_date;
        $this->status = $this->template->status;
    }

    private function dehidrate()
    {
        $this->template->title = $this->title;
        $this->template->description = $this->description;
        $this->template->start_date = $this->start_date;
        $this->template->end_date = $this->end_date;
        $this->template->status = $this->status;
    }

}
