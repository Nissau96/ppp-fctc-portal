<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectDataTableController;
use App\Http\Controllers\ReportController;

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // download attachments (simple route)
    Route::get('/projects/{project}/download/{index?}', function (\App\Models\Project $project, $index = 0) {
        $paths = $project->attachments ?? [];
        if (!isset($paths[$index])) abort(404);
        return response()->download(storage_path('app/public/' . $paths[$index]));
    })->name('projects.download');

    Route::get('/api/projects/datatables', [ProjectDataTableController::class, 'index'])->name('api.projects.datatables');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/api/reports/projects-by-status', [ReportController::class, 'projectsByStatus']);
    Route::get('/api/reports/monthly-projects', [ReportController::class, 'monthlyProjects']);
});
