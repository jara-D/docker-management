<?php

namespace App\Http\Controllers;

use App\Adapters\GoServiceAdapter;
use App\Models\Project;
use App\Services\ContainerSyncService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct(
        protected GoServiceAdapter $go
    ) {}

    public function index(): Response
    {
        $projects = Project::with([
            'containers:id,project_id,state'
        ])->get(['id', 'name', 'type']);

        return Inertia::render('Projects', [
            'projects' => $projects,
        ]);
    }

    public function status(Project $project): Response
    {
        $project->load([
            'containers:id,project_id,name,state,image'
        ]);

        return Inertia::render('Project/Status', [
            'project' => $project,
        ]);
    }

    public function start(Project $project): RedirectResponse
    {
        $project->load('containers:id,project_id,container_id');

        foreach ($project->containers as $container) {
            $this->go->startContainer($container->container_id);
        }

        $dockerData = $this->go->listContainers(); // or inspect each container

        app(ContainerSyncService::class)->projectSync(
            $project->id,
            $dockerData
        );

        return back()->with('flash', [
            'message' => 'Projects started',
            'type' => 'success',
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function stop(Project $project): RedirectResponse
    {
        $project->load('containers:id,project_id,container_id');

        foreach ($project->containers as $container) {
            $this->go->stopContainer($container->container_id);
        }

        $dockerData = $this->go->listContainers(); // or inspect each container

        app(ContainerSyncService::class)->projectSync(
            $project->id,
            $dockerData
        );

        return back()->with('flash', [
            'message' => 'Projects stopped',
            'type' => 'success',
        ]);
    }

    public function delete(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted');
    }
}
