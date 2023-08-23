<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagModal extends Component
{
    public $tag;
    public $showModal = false;
    public $colorSelected = 'success';

    protected $rules = [
        'tag.label' => 'required|min:2',
        'tag.user_id' => 'required',
        'tag.description'=>'',
        'tag.color' => ''
    ];

    protected $listeners = ['openTagModal' => 'openTagModal'];

    public function openTagModal($tag_id)
    {
        $this->tag = new Tag();
        if($tag_id > 0) {
            $this->tag = Tag::find($tag_id);
            // $this->selectedColor = $this->tag->color;
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
        $this->tag->user_id = $user->id;

        $this->tag->save();
        $this->tag->refresh();

        $this->emit('refreshTag');
        $this->showModal = false;

    }

    public function mount()
    {
        $this->tag = new Tag();
    }

    public function render()
    {
        return view('livewire.tag-modal');
    }
}
