<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use Usamamuneerchaudhary\Commentify\Http\Livewire\Comments;

class CpmComments extends Comments
{
    protected $listeners = [
        'taskModalOpenForCommentModel' => 'onOpenTaskModal',
        'refresh' => '$refresh'
    ];

    protected $validationAttributes = [
        'newCommentState.body' => 'comment'
    ];

    public function onOpenTaskModal(Task $task)
    {
        $this->model = $task;
    }

}
