<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TemplateProjects extends Component
{
    public $templates = [];
    public $project = null;
    public $showTemplateModal = false;

    protected $listeners = ['refreshTemplate' => '$refresh'
    ];

    public function addNewTemplate()
    {
        $this->emit('openTemplateModal', null);
    }

    public function mount()
    {
        $this->templates = Project::where('is_template', true)->get();
        $this->templates = $this->templates->map(function($template) {
            $template->duration = '';
            if ($template->start_date && $template->end_date) {
                $template->duration = $this->getDuration($template);
            }
            return $template;
        });

        $projectId = Auth::user()->project_id;
        if($this->project != null) {
            $this->project = Project::find($projectId);
        }
    }

    public function editTemplate($id)
    {
        $this->emit('openTemplateModal', $id);
    }

    public function deleteTemplate($id)
    {
        $res=Project::where('id', $id)->delete();
        // $this->emit('openPriorityModal', $priority_id);
    }

    public function render()
    {
        return view('livewire.template-projects');
    }

    //------------------------------------------------------------
    private function getDuration(Project $template): string
    {
        $start = Carbon::parse($template->start_date);
        $end = Carbon::parse($template->end_date);
        $diff = $start->diff($end); 

        $years = $diff->y; 
        $months = $diff->m; 

        $message = '';
        if ($years > 0) {
            $message .= $years . ' year' . ($years > 1 ? 's' : ''); 
        }
        if ($months > 0) {
            $message .= ($message ? ' and ' : '') . $months . ' month' . ($months > 1 ? 's' : ''); 
        }
        return $message;
    }
}
