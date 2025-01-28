<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\Tag;
use App\Models\Report;
use App\Models\TaskStatus;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\DB;

class ProjectModal extends Component
{
    public Project $project;
    public $showProjectModal = false;
    public $readOnly = '';
    public $templates = [];
    public $selectedTemplate = 0;
    private $taskStatusMap = [];
    private $taskPriorityMap = [];

    protected $rules = [
        'project.title' => 'required|min:2',
        'project.user_id' => 'required',
        'project.description'=>'',
        'project.start_date'=>'',
        'project.end_date'=>'',
        'project.status' => 'required'
    ];

    protected $listeners = ['openProjectModal' => 'openProjectModal'];

    public function openProjectModal($project)
    {
        $this->templates = Project::where('is_template', true)->get();
        if($project == null){
            $this->project = new Project();
        } else {
            $this->project = Project::find($project['id']) ?? new Project();
        }
        
        $this->showProjectModal = true;
    }

    // public function openProjectModal($report_id)
    // {
    //     $this->project = new Report();
    //     if($report_id > 0){
    //         $this->project = Report::find($report_id);
    //     }

    //     $this->showProjectModal = true;
    // }

    public function closeModal()
    {
        $this->showProjectModal = false;
    }

    public function store()
    {
        $user = Auth::user();
        $is_new = $this->project->id == null;
        
        if ($user) {
            $this->project->user_id = $user->id;
        } else {
            // Handle the case when the user is not authenticated
            return;
        }
        $this->project->status = $this->project->status == '' ? 'ACTIVE' : $this->project->status;

        
        DB::beginTransaction();
        $this->project->save();

        if($is_new && $this->selectedTemplate > 0){
            $template = Project::find($this->selectedTemplate);
            if($this->createProjectFromTemplate($template)){
                DB::commit();
            } else {
                DB::rollBack();
            }
        } else{
            DB::commit();
        }
        // $this->project->refresh();
        $this->emit('refreshProjects');
        $this->showProjectModal = false;

    }

    public function mount()
    {
        $this->project = new Project();
        $user =  Auth::user();
        // if(!$user->hasRole('Project Manager')){
        //     $this->readOnly = 'readonly';
        // }
    }

    public function render()
    {
        return view('livewire.project-modal');
    }

    //--------------------- private methods ---------------------

    private function createProjectFromTemplate(Project $source) : bool
    {
        if($source == null){
            return false;
        }
        $user = Auth::user();


        try {  
            //Assume there is only three levels of tasks with level value of 0, 1, 2
            // ---------delete all existing tasks of the template project---------------
            // for ($i = 2; $i >= 0; $i--) {
            //     $tasks = $this->project->getTasksByLevel($i);
            //     foreach($tasks as $task){
            //         $task->delete();
            //     }
            // }
            $projectDate = Carbon::parse($this->project->start_date);
            $templateDate = Carbon::parse($source->start_date);
            $slackDays = $projectDate->diffInDays($templateDate);
            $this->createTags($source->getTags(), $user->id);
            // $sourceTags = $source->getTags();
            // foreach($sourceTags as $sourceTag){
            //     $tag = Tag::create([
            //         'label' => $sourceTag->label,
            //         'description' => $sourceTag->description,
            //         'color' => $sourceTag->color,
            //         'user_id' => $user->id,
            //         'project_id' => $this->project->id
            //     ]);
            // }
            $this->createStatuses($source->getTaskStatuses(), $user->id);
            // $sourceStatuses = $source->getTaskStatuses();
            

            // foreach ($sourceStatuses as $status) {
            //     $taskStatus = TaskStatus::create([
            //         'value' => $status->value,
            //         'description' => $status->description,
            //         'color' => $status->color,
            //         'kanban_list_rank' => $status->kanban_list_rank,
            //         'user_id' => $user->id,
            //         'project_id' => $this->project->id
            //     ]);

            //     $this->taskStatusMap[$status->value] = $taskStatus->id;
            // }

            $this->createPriorities($source->getTaskPriorities(), $user->id);
            // $sourcePriorities = $source->getTaskPriorities();
            // foreach ($sourcePriorities as $priority) {
            //     $taskPriority = TaskPriority::create([
            //         'value' => $priority->value,
            //         'description' => $priority->description,
            //         'color' => $priority->color,
            //         'user_id' => $user->id,
            //         'project_id' => $this->project->id
            //     ]);

            //     $this->taskPriorityMap[$priority->value] = $taskPriority->id;
            // }

            $this->createReports($source->getReports(), $user->id);
            $this->copyTasks($source->getTasksByLevel(0), null, "", $user->id, 0, $slackDays);

            // for ($i = 0; $i <= 2; $i++) {
            //     $sourceTasks = $source->getTasksByLevel($i);
            //     foreach($sourceTasks as $sourceTask){
            //         $task = new Task();
            //         $task->project_id = $this->project->id;
            //         $task->title = $sourceTask->title;
            //         $task->description = $sourceTask->description;
            //         $task->start_date = Carbon::parse($sourceTask->start_date)->addDays($slackDays);
            //         $task->end_date = Carbon::parse($sourceTask->end_date)->addDays($slackDays);
            //         $task->user_id = $user->id;
            //         $task->text = $sourceTask->text;
                    
            //         $task->kanban_list_rank = $sourceTask->kanban_list_rank;
            //         $task->duration = $sourceTask->duration;
            //         $task->type = $sourceTask->type;
            //         $task->level = $sourceTask->level;
            //         $task->list_order = $sourceTask->list_order;
            //         $task->is_starred = $sourceTask->is_starred;
            //         $task->path = $sourceTask->path;
            //         $task->original_id = $sourceTask->id;
            //         $task->task_priority_id = $taskPriorityMap[$sourceTask->taskPriority?->value] ?? null;
            //         $task->task_status_id = $taskStatusMap[$sourceTask->taskStatus?->value] ?? null;

            //         if($sourceTask->parent != null){
            //             $parentTask = Task::where('original_id', $sourceTask->parent)
            //                                 ->where('project_id', $this->project->id)->first();
            //             $task->parent = $parentTask->id;
            //         }

            //         $task->save();
            //     }
            // }
        } catch (\Exception $e) {
            logger($e->getMessage());
            $this->emit('errorCreatingProjectFromTemplate', 'Error creating project from template');
            return false;
        }

        return true;
    }
    
    private function createStatuses($sourceStatuses, $user_id)
    {
        foreach ($sourceStatuses as $status) {
            $taskStatus = TaskStatus::create([
                'value' => $status->value,
                'description' => $status->description,
                'color' => $status->color,
                'kanban_list_rank' => $status->kanban_list_rank,
                'user_id' => $user_id,
                'project_id' => $this->project->id
            ]);

            $this->taskStatusMap[$status->value] = $taskStatus->id;
        }
    }

    private function createTags($sourceTags, $user_id)
    {
        foreach($sourceTags as $sourceTag){
            $tag = Tag::create([
                'label' => $sourceTag->label,
                'description' => $sourceTag->description,
                'color' => $sourceTag->color,
                'user_id' => $user_id,
                'project_id' => $this->project->id
            ]);
        }
    }

    private function createPriorities($sourcePriorities, $user_id)
    {
        foreach ($sourcePriorities as $priority) {
            $taskPriority = TaskPriority::create([
                'value' => $priority->value,
                'description' => $priority->description,
                'color' => $priority->color,
                'user_id' => $user_id,
                'project_id' => $this->project->id
            ]);

            $this->taskPriorityMap[$priority->value] = $taskPriority->id;
        }
    }

    private function createReports($sourceReports, $user_id)
    {
        foreach ($sourceReports as $item) {
            $report = Report::create([
                'title' => $item['title'],
                'description' => $item['description'],
                'select_clause' => $item['select_clause'],
                'from_clause' => $item['from_clause'],
                'where_clause' => $item['where_clause'],
                'order_clause' => $item['order_clause'],
                'groupby_clause' => $item['groupby_clause'],
                'having_clause' => $item['having_clause'],
                'published' => $item['published'],
                'user_id' => $user_id,
                'project_id' => $this->project->id
            ]);
        }
    }

    private function copyTasks($sourceTasks, $parent_id, $parentPath,
        $user_id, $level, $slackDays)
    {
        foreach($sourceTasks as $sourceTask){
            $task = new Task();
            $task->project_id = $this->project->id;
            $task->title = $sourceTask->title;
            $task->description = $sourceTask->description;
            $task->start_date = Carbon::parse($sourceTask->start_date)->addDays($slackDays);
            $task->end_date = Carbon::parse($sourceTask->end_date)->addDays($slackDays);
            $task->user_id = $user_id;
            $task->text = $sourceTask->text;
            
            $task->kanban_list_rank = $sourceTask->kanban_list_rank;
            $task->duration = $sourceTask->duration;
            $task->type = $sourceTask->type;
            $task->level = $sourceTask->level;
            $task->list_order = $sourceTask->list_order;
            $task->is_starred = $sourceTask->is_starred;
            $task->task_priority_id = $this->taskPriorityMap[$sourceTask->taskPriority?->value] ?? null;
            $task->task_status_id = $this->taskStatusMap[$sourceTask->taskStatus?->value] ?? null;
            
            $task->parent = $parent_id;
            $task->save();

            $taskPath = $level == 0 ? $task->id : "{$parentPath}.{$task->id}";
            $task->path = $taskPath;
            $task->save();

            if ($level < 2 && isset($sourceTask->children)) {
                $this->copyTasks($sourceTask->children, $task->id, $taskPath, $user_id,
                    $level + 1, $slackDays);
            }
        }
    }
}
