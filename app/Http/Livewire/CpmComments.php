<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use Livewire\Attributes\On;
use Usamamuneerchaudhary\Commentify\Http\Livewire\Comments;

class CpmComments extends Comments
{
    // protected $listeners = [
    //     'taskModalOpenForCommentModel' => 'onOpenTaskModal',
    //     'refresh' => '$refresh'
    // ];

    
    protected $validationAttributes = [
        'newCommentState.body' => 'comment'
    ];

    #[On('taskModalOpenForCommentModel')]
    public function onOpenTaskModal(Task $task)
    {
        logger('Comment');
        $this->model = $task;
    }

    /**
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|null
     */
    public function render(
        ): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|null
        {
            $comments = $this->model
                ->comments()
                ->with('user', 'children.user', 'children.children')
                ->parent()
                ->latest()
                ->paginate(config('commentify.pagination_count',10));
            return view('commentify::livewire.comments', [
                'comments' => $comments
            ]);
        }

}
