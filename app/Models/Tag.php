<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'color', 'description', 'user_id', 'project_id'];

    /**
     * The tags that belong to the task.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'tag_task');
    }

}
