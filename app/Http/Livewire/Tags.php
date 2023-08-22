<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tag;
use Livewire\WithPagination;

class Tags extends Component
{
    use WithPagination;

    // public $tags = [];
    public $showTagModal = false;

    protected $listeners = ['refreshTag' => '$refresh'
    ];

    public function addNewTag()
    {
        $this->emit('openTagModal', null);
    }

    public function editTag($tag_id)
    {
        $this->emit('openTagModal', $tag_id);
    }

    public function deleteTag($tag_id)
    {
        $res=Tag::where('id', $tag_id)->delete();
        $this->emit('openTagModal', $tag_id);
    }

    public function render()
    {
        return view('livewire.tags', [
            'tags' => Tag::paginate(10),
        ]);
    }
}
