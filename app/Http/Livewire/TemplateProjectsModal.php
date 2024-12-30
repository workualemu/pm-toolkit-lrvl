<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TemplateProjectsModal extends Component
{
    public Project $template;
    public $projects = [];
    public $showModal = false;
    public $readOnly = '';
    public $sourceProject = 0;

    protected $rules = [
        'template.title' => 'required|min:2',
        'template.user_id' => 'required',
        'template.description'=>'',
        'template.start_date'=>'',
        'template.end_date'=>'',
        'template.status' => 'required'
    ];

    protected $listeners = ['openTemplateModal' => 'openTemplateModal'];

    public function openTemplateModal($template_id)
    {
        if($template_id == null){
            $this->template = new Project();
        } else {
            $this->template = Project::find($template_id);
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $user = Auth::user();
        
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
        $this->template->save();
        $this->template->refresh();

        $this->copyTemplateFromSource($sourceProject);

        $this->emit('refreshTemplate');
        $this->showModal = false;
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
        return view('livewire.template-projects-modal');
    }

    //--------------------- private methods ---------------------

    private function copyTemplateFromSource(Project $source) : bool
    {
        if($source == null){
            return false;
        }
        $user = Auth::user();
        //Assume there is only three levels of tasks with level value of 0, 1, 2
        // ---------delete all existing tasks of the template project---------------
        for ($i = 2; $i >= 0; $i--) {
            $templateTasks = $this->template->getTasksByLevel($i);
            foreach($templateTasks as $task){
                $task->delete();
            }
        }
        // ---------copy all source project tasks to the template project---------------
        for ($i = 0; $i <= 2; $i++) {
            $sourceTasks = $source->getTasksByLevel($i);
            foreach($sourceTasks as $sourceTask){
                $task = new Task();
                $task->project_id = $this->template->id;
                $task->title = $sourceTask->title;
                $task->description = $sourceTask->description;
                $task->start_date = $sourceTask->start_date;
                $task->planned_end_date = $sourceTask->planned_end_date;
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
