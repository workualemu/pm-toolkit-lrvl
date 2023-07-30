<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $records = Project::orderBy('title')->get();
        $colors = ['info', 'primary', 'secondary', 'success', 'error', 'warning'];

        return view('project.index', compact('records', 'colors'));
    }

    public function create()
    {
        return view('project.create');
    }

    public function store(ProjectRequest $request)
    {

        $request->merge(array('user_id' => Auth::user()->id));

        Project::create($request->only([
            'title', 'start_date', 'end_date', 'description', 'status', 'user_id'
        ]));
        return redirect()->route('project.index')->withMessage('Record created');

    }

    public function edit(Project $project)
    {
        return view('project.edit', compact('project'));
    }

    public function update(Project $project, ProjectRequest $request)
    {
        $project->update($request->only([
            'title', 'start_date', 'end_date', 'description', 'status', 'user_id'
        ]));
        return redirect()->route('project.index')->withMessage('Record updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('project.index')->withMessage('Record deleted');
    }
}
