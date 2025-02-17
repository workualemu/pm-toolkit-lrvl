<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;

class TagModal extends Component
{
    public $tag;
    public $showModal = false;
    public $colorSelected = 'success';
    public $currentColor;

    #[LivewireRule('required|string|min:2')] 
    public $label;
    public $user_id;
    public $description;
    public $color;

    protected $listeners = ['openTagModal' => 'openTagModal'];

    public function openTagModal($tag_id)
    {
        $this->tag = new Tag();
        if($tag_id > 0) {
            $this->tag = Tag::find($tag_id);
        }
        $this->currentColor =  $this->status->color ?? 'blue';
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
        $this->tag->color =  $this->currentColor;
        $this->tag->save();
        $this->tag->refresh();

        $this->dispatch('refreshTag');
        $this->showModal = false;

    }

    public function mount()
    {
        $this->tag = new Tag();
    }

    public function render()
    {
        return view('livewire.settings.tag-modal');
    }
}
