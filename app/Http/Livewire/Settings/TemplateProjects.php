<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Attributes\On;

class TemplateProjects extends Component
{
    public $templates = [];
    public $project = null;
    public $searchTerm;

    protected $listeners = ['refreshTemplate' => '$refresh'
    ];

    #[On('refreshTemplate')]
    public function refreshTemplate()
    {
        $this->dispatch('$refresh');
    }

    public function addNewTemplate()
    {
        $this->dispatch('openTemplateModal', null);
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
        if($this->project == null) {
            $this->project = Project::find($projectId);
        }
    }

    public function editTemplate($id)
    {
        $this->dispatch('openTemplateModal', $id);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        Project::findOrFail($id)->delete();
        $this->dispatch('$refresh');
    }


    public function render()
    {
        $searchTerm = '%' . strtolower($this->searchTerm) . '%';

        $templates = Project::where('is_template', true) // Always apply `is_template = true` first
        ->when($this->searchTerm, function ($query) use ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
            });
        })
        ->orderBy('start_date')
        ->paginate(10);
        $templates->getCollection()->transform(function ($template) {
            $template->duration = ($template->start_date && $template->end_date)
                ? $this->getDuration($template)
                : '';
            return $template;
        });

        return view('livewire.settings.template-projects', [
            'records' => $templates
        ]);
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
