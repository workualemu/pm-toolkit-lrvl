<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Tag;
use App\Models\Project;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Tags extends Component
{
    use WithPagination;

    public $searchTerm;
    public $project;

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }
    
    #[On('refreshTag')]
    public function refreshTag()
    {
        $this->dispatch('$refresh');
    }

    public function addNewTag()
    {
        $this->dispatch('openTagModal', null);
    }

    public function editTag($tag_id)
    {
        $this->dispatch('openTagModal', $tag_id);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        try{
            $selectedItem = Tag::find($id);
            if($selectedItem->delete()){
                $this->dispatch('status-message', success: true, message: 'Tag has been deleted successfully!');
            } else {
                $this->dispatch('status-message', success: false, message: 'Tag cannot be deleted!');
            }
            $selectedItem->refresh();
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $this->project = Project::find(auth()->user()->project_id);
        $searchTerm = '%' . strtolower($this->searchTerm) . '%';

        $records = Tag::where('project_id', auth()->user()->project_id) 
            ->when($this->searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(label) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
                });
            })
            ->paginate(10);

        if ($records->isEmpty() && $this->getPage() > 1) {
            $this->resetPage(); 
        }

        return view('livewire.settings.tags', [
            'tags' => $records,
        ]);
    }
}
