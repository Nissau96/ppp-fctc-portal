<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $completed = Project::where('status', 'completed')->count();
        $inProgress = Project::where('status', 'in_progress')->count();
        return view('projects.index', compact('totalProjects', 'completed', 'inProgress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'registration_id' => 'nullable|string|max:100|unique:projects,registration_id',
            'mda' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric',
            'attachments.*' => 'file|max:512000', // max 500MB per file in KB
        ]);

        $project = Project::create([
            'registration_id' => $request->registration_id ?? 'REG-' . strtoupper(Str::random(8)),
            'title' => $request->title,
            'mda' => $request->mda,
            'sector' => $request->sector,
            'description' => $request->description,
            'cost' => $request->cost,
            'status' => $request->status ?? 'submitted',
            'created_by' => auth()->id(),
            'date_of_entry' => now(),
            'expected_start' => $request->expected_start,
            'expected_end' => $request->expected_end,
        ]);

        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store("projects/{$project->id}", 'public');
                $paths[] = $path;
            }
            $project->update(['attachments' => $paths]);
        }

        return redirect()->route('projects.index')->with('success', 'Project created.');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'attachments.*' => 'file|max:512000',
        ]);

        $project->update($request->only(['title', 'mda', 'sector', 'description', 'cost', 'status', 'expected_start', 'expected_end']));

        $paths = $project->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store("projects/{$project->id}", 'public');
            }
            $project->update(['attachments' => $paths]);
        }

        return back()->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Project deleted.');
    }
}
