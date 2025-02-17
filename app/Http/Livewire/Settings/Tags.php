<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Tag;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Tags extends Component
{
    use WithPagination;

    public $showTagModal = false;

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
        Tag::findOrFail($id)->delete();
        session()->flash('message', 'Tag deleted successfully.');
    }

    public function render()
    {
        $user = \Auth::user();
        return view('livewire.settings.tags', [
            'tags' => Tag::where('project_id', $user->project_id)->paginate(10),
        ]);
    }
}
