<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','name', 'task_id'
    ];

    public static function scopeFilterByTask($query, $task_id)
    {
        return $query->where('task_id', '=', $task_id);
    }

    public function getClientOriginalName()
    {
        return $this['title'];
    }

    public function getFilename()
    {
        return $this['name'];
    }
}
