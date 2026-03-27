<?php

namespace App\Http\Controllers;

use App\Adapters\GoServiceAdapter;
use App\Models\Project;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects', [
            'projects' => Project::with([
                'containers:project_id,state'
            ])->get(['id', 'name']),
        ]);
    }
    public function status(Project $project)
    {
        $project->load([
            'containers:id,project_id,name,state'
        ]);

        return Inertia::render('Project/Status', [
            'project' => $project,
        ]);
    }


    public function start(Project $project)
    {
        foreach ($project->containers as $container) {
            app(GoServiceAdapter::class)->startContainer($container->container_id);
        }

        return back();
    }

    public function stop(Project $project)
    {
        foreach ($project->containers as $container) {
            app(GoServiceAdapter::class)->stopContainer($container->container_id);
        }

        return back();
    }

}
