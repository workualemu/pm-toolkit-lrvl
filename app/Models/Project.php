<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'start_date', 'end_date', 'description', 'status', 'user_id'];

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'project_id', 'id');
    }

    public function getTasksByLevel($level)
    {
        return Task::where('project_id', '=', $this->id)
            ->where('level', '=', $level)
            ->get();
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'project_id', 'id');
    }

    public function getTaskPriorities()
    {
        return TaskPriority::where('project_id', '=', $this->id)
            ->get();
    }

    public function getTaskStatus()
    {
        return TaskStatus::where('project_id', '=', $this->id)
            ->get();
    }

    public function getReports()
    {
        return Report::where('project_id', '=', $this->id)
            ->get();
    }

    public function getReportParams()
    {
        return ReportParam::where('project_id', '=', $this->id)
            ->get();
    }

    public function getReportColumns()
    {
        return ReportColumn::where('project_id', '=', $this->id)
            ->get();
    }
}
