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
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;

class ProjectModal extends Component
{
    public Project $project;
    public $showProjectModal = false;
    public $readOnly = '';
    public $templates = [];
    public $selectedTemplate = 0;

    #[LivewireRule('required|string|min:2')]
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $status;

    private $taskStatusMap = [];
    private $taskPriorityMap = [];
    private $tagMap = [];

    // protected $rules = [
    //     'title' => 'required|min:2',
    //     'user_id' => 'required',
    //     'description'=>'',
    //     'start_date'=>'',
    //     'end_date'=>'',
    //     'status' => 'required'
    // ];

    // protected $listeners = ['openProjectModal' => 'openProjectModal'];

    #[On('openProjectModal')]
    public function openProjectModal($project)
    {
        $this->templates = Project::where('is_template', true)->get();
        if($project == null){
            $this->project = new Project();
        } else {
            $this->project = Project::find($project['id']) ?? new Project();
        }
        $this->hidrate();
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
        $this->dehidrate();
        if ($user) {
            $this->project->user_id = $user->id;
        } else {
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
        
        $this->dispatch('refreshProjects');
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
            
            $projectDate = Carbon::parse($this->project->start_date);
            $templateDate = Carbon::parse($source->start_date);
            $slackDays = $templateDate->diffInDays($projectDate);
            $this->createTags($source->getTags(), $user->id);
            $this->createStatuses($source->getTaskStatuses(), $user->id);
            $this->createPriorities($source->getTaskPriorities(), $user->id);
            $this->createReports($source->getReports(), $user->id);
            $this->copyTasks($source->getTasksByLevel(0), null, "", $user->id, 0, $slackDays);
        } catch (\Exception $e) {
            logger($e->getMessage());
            $this->dispatch('errorCreatingProjectFromTemplate', 'Error creating project from template');
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
            $this->tagMap[$tag->label] = $tag->id;
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
            $task->refresh();

            $tagMap = $this->tagMap;
            $modifiedTagIds = $sourceTask->getTaskTags()->map(function ($tag) use ($tagMap) {
                $tag->newId = $tagMap[$tag->label];
                return $tag;
            });
            $savedTags = Tag::whereIn('id', $modifiedTagIds->pluck('newId'))->get();
            $task->tags()->sync($savedTags);

            $taskPath = $level == 0 ? $task->id : "{$parentPath}.{$task->id}";
            $task->path = $taskPath;
            $task->save();

            if ($level < 2 && isset($sourceTask->children)) {
                $this->copyTasks($sourceTask->children, $task->id, $taskPath, $user_id,
                    $level + 1, $slackDays);
            }
        }
    }

    private function hidrate()
    {
        $this->title = $this->project->title;
        $this->description = $this->project->description;
        $this->start_date = $this->project->start_date;
        $this->end_date = $this->project->end_date;
        $this->status = $this->project->status;
    }

    private function dehidrate()
    {
        $this->project->title = $this->title;
        $this->project->description = $this->description;
        $this->project->start_date = $this->start_date;
        $this->project->end_date = $this->end_date;
        $this->project->status = $this->status;
    }
}
