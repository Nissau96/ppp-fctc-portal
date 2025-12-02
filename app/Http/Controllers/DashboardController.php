<?php

namespace App\Http\Controllers;

use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Project::count();
        $completed = Project::where('status', 'completed')->count();
        $inProgress = Project::where('status', 'in_progress')->count();
        $active = Project::where('status', 'active')->count();
        $latest = Project::latest()->take(10)->get();
        return view('dashboard.index', compact('total', 'completed', 'inProgress', 'active', 'latest'));
    }
}
