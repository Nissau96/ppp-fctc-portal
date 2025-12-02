<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectDataTableController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query()->select(['id', 'registration_id', 'title', 'mda', 'sector', 'status', 'cost', 'date_of_entry', 'created_at']);
        return DataTables::of($query)
            ->editColumn('date_of_entry', function ($p) {
                return $p->date_of_entry?->format('Y-m-d') ?? $p->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function ($p) {
                $view = route('projects.show', $p->id);
                $edit = route('projects.edit', $p->id);
                $download = route('projects.download', $p->id);
                $delete = route('projects.destroy', $p->id);
                return view('projects.partials.datatable-actions', compact('p', 'view', 'edit', 'download', 'delete'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
