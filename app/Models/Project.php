<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'start_date', 'end_date', 'description', 'status', 'user_id'];

    
    public function getTasksByLevel($level)
    {
        return Task::where('project_id', '=', $this->id)
            ->where('level', '=', $level)
            ->get();
    }

}
