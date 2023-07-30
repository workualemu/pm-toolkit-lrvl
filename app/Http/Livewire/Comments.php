<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    // use WithPagination;

    public $task_id;
    public $model;

    public $users = [];

    public $showDropdown = false;

    public $newCommentState = [
        'body' => ''
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    protected $validationAttributes = [
        'newCommentState.body' => 'comment'
    ];

    // public function mount()
    // {
        
    // }

    public function render()
    {

        // if($this->task_id > 0) {
        //     $this->model = Task::find($this->task_id);
        // } else {
        //     $this->model = new Task();
        // }

        // $comments = \App\Models\Comment::whereHasMorph(
        //     'commentable',
        //     [Task::class],
        //     function (\Illuminate\Database\Eloquent\Builder $query) {
        //         $query->where('id', '=', 16);
        //     }
        // )->get();
        $this->task_id = 16;
        // $this->model = \App\Models\Task::find($this->task_id);
        $comments = $this->model
            ->comments()
            ->with('user', 'children.user', 'children.children')
            ->parent()
            ->latest();

        return view('livewire.comments', [
            'comments' => $comments
        ]);
        
    }

    /**
     * @return void
     */
    public function postComment(): void
    {
        
        $this->model = \App\Models\Task::find($this->task_id);

        $this->validate([
            'newCommentState.body' => 'required'
        ]);

        $comment = $this->model->comments()->make($this->newCommentState);
        
        $comment->user()->associate(auth()->user());
        $comment->save();

        $this->newCommentState = [
            'body' => ''
        ];
        $this->users = [];
        $this->showDropdown = false;

        $this->resetPage();
        session()->flash('message', 'Comment Posted Successfully!');
    }

}
