<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function projectsByStatus()
    {
        $data = Project::selectRaw('status, COUNT(*) as total')->groupBy('status')->get();
        $result = $data->map(fn($r) => ['name' => $r->status, 'value' => $r->total])->toArray();
        return response()->json($result);
    }

    public function monthlyProjects()
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }

        $rows = Project::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $data = array_map(fn($m) => $rows[$m] ?? 0, $months);
        return response()->json(['months' => $months, 'data' => $data]);
    }
}
