<?php

namespace App\Http\Controllers;

use App\Adapters\GoServiceAdapter;
use App\Models\Project;
use App\Services\ContainerSyncService;
use Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;

class ProjectController extends Controller
    {
    public function __construct(
        protected GoServiceAdapter $go
    ) {}

    public function index(): Response
    {
        $projects = Auth::user()
            ->projects()
            ->with(['containers:id,project_id,state'])
            ->get(['id', 'name', 'type'])
            ->makeHidden('containers');

        return Inertia::render('Projects', [
            'projects' => $projects,
        ]);
    }

    public function status(Project $project): Response
    {
        $project->load([
            'containers:id,project_id,name,state,image',
        ]);

        $logs = Activity::where('properties->project_id', $project->id)
            ->latest()
            ->take(20)
            ->get(['id', 'description', 'created_at']);

        return Inertia::render('Project/Status', [
            'project' => $project,
            'logs' => $logs,
        ]);
    }

    public function start(Project $project): RedirectResponse
    {
        $project->load('containers:id,project_id,container_id');

        $failures = [];
        foreach ($project->containers as $container) {
            $response = $this->go->startContainer($container->container_id);
            $decoded = json_decode(json_encode($response));

            if (! isset($decoded->result->state) || $decoded->result->state !== 'started') {
                $failures[] = $container->container_id;
            }
        }

        $dockerData = $this->go->listContainers();
        app(ContainerSyncService::class)->projectSync($project->id, $dockerData);

        if (! empty($failures)) {
            activity()
                ->causedBy(Auth::user())
                ->withProperties(['project_id' => $project->id])
                ->log("Project starten mislukt: {$project->name}");

            return back()->with('flash', [
                'title' => 'Failed',
                'message' => 'Some containers failed to start',
                'type' => 'error',
            ]);
        }

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['project_id' => $project->id])
            ->log("Project gestart: {$project->name}");

        return back()->with('flash', [
            'title' => 'Started',
            'message' => 'All project containers started successfully',
            'type' => 'success',
        ]);
    }

    public function stop(Project $project): RedirectResponse
    {
        $project->load('containers:id,project_id,container_id');

        $failures = [];
        foreach ($project->containers as $container) {
            $response = $this->go->stopContainer($container->container_id);
            $decoded = json_decode(json_encode($response));

            if (! isset($decoded->result->state) || $decoded->result->state !== 'stopped') {
                $failures[] = $container->container_id;
            }
        }

        $dockerData = $this->go->listContainers();
        app(ContainerSyncService::class)->projectSync($project->id, $dockerData);

        if (! empty($failures)) {
            activity()
                ->causedBy(Auth::user())
                ->withProperties(['project_id' => $project->id])
                ->log("Project stoppen mislukt: {$project->name}");

            return back()->with('flash', [
                'title' => 'Failed',
                'message' => 'Some containers failed to stop',
                'type' => 'error',
            ]);
        }

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['project_id' => $project->id])
            ->log("Project gestopt: {$project->name}");

        return back()->with('flash', [
            'title' => 'Stopped',
            'message' => 'All project containers stopped successfully',
            'type' => 'success',
        ]);
    }

    public function delete(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('flash', [
                'title' => 'Deleted',
                'message' => 'Project deleted',
                'type' => 'success',
            ]);
    }
}
