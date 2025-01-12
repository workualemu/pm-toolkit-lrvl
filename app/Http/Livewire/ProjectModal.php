<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Task;

class ProjectModal extends Component
{
    public Project $project;
    public $showProjectModal = false;
    public $readOnly = '';
    public $templates = [];
    public $selectedTemplate = 0;

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
            $this->project = Project::find($project['id']);
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
        
        $this->project->user_id = $user->id;
        $this->project->status = $this->project->status == '' ? 'ACTIVE' : $this->project->status;

        $this->project->save();
        $this->project->refresh();

        if($this->selectedTemplate > 0){
            $template = Project::find($this->selectedTemplate);
            $this->copyProjectFromTemplate($template);
        }

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

    private function copyProjectFromTemplate(Project $source) : bool
    {
        if($source == null){
            return false;
        }
        $user = Auth::user();
        //Assume there is only three levels of tasks with level value of 0, 1, 2
        // ---------delete all existing tasks of the template project---------------
        for ($i = 2; $i >= 0; $i--) {
            $tasks = $this->project->getTasksByLevel($i);
            foreach($tasks as $task){
                $task->delete();
            }
        }
        $projectDate = Carbon::parse($this->project->start_date);
        $templateDate = Carbon::parse($source->start_date);
        $slackDays = $projectDate->diffInDays($templateDate);
        // ---------copy all source project tasks to the template project---------------
        for ($i = 0; $i <= 2; $i++) {
            $sourceTasks = $source->getTasksByLevel($i);
            foreach($sourceTasks as $sourceTask){
                $task = new Task();
                $task->project_id = $this->project->id;
                $task->title = $sourceTask->title;
                $task->description = $sourceTask->description;
                $task->start_date = Carbon::parse($sourceTask->start_date)->addDays($slackDays);
                $task->end_date = Carbon::parse($sourceTask->end_date)->addDays($slackDays);
                $task->user_id = $user->id;
                $task->text = $sourceTask->text;
                $task->task_type_id = $sourceTask->task_type_id;
                $task->task_status_id = $sourceTask->task_status_id;
                $task->task_priority_id = $sourceTask->task_priority_id;
                $task->kanban_list_rank = $sourceTask->kanban_list_rank;
                $task->duration = $sourceTask->duration;
                $task->type = $sourceTask->type;
                $task->level = $sourceTask->level;
                $task->list_order = $sourceTask->list_order;
                $task->is_starred = $sourceTask->is_starred;
                $task->path = $sourceTask->path;
                $task->original_id = $sourceTask->id;

                if($sourceTask->parent != null){
                    $parentTask = Task::where('original_id', $sourceTask->parent)->first();
                    $task->parent = $parentTask->id;
                }

                $task->save();
            }
        }

        return true;
    }
}
