<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectModal extends Component
{
    public Project $project;
    public $showProjectModal = false;

    protected $rules = [
        'project.title' => 'required|min:2',
        'project.user_id' => 'required',
        'project.description'=>'',
        'project.start_date'=>'',
        'project.end_date'=>'',
        'reprojectport.status' => 'required'
    ];

    protected $listeners = ['openProjectModal' => 'openProjectModal'];

    public function openProjectModal($project)
    {
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
        
        $this->project->save();
        $this->project->refresh();

        $this->emit('refreshProjects');
        $this->showProjectModal = false;

    }

    public function mount()
    {
        $this->project = new Project();
    }

    public function render()
    {
        return view('livewire.project-modal');
    }
}
