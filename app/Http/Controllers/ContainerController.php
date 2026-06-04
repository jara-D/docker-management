<?php

namespace App\Http\Controllers;

use App\Adapters\Interface\ContainerInterface;
use App\Http\Requests\ComposeUpRequest;
use App\Models\Project;
use App\Services\ContainerSyncService;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class ContainerController extends Controller
{
    private ContainerInterface $adapter;

    public function __construct(ContainerInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function index()
    {
        return response()->json($this->adapter->listContainers());
    }

    public function start(string $id)
    {
        $result = $this->adapter->startContainer($id);

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['container_id' => $id])
            ->log("Container gestart: {$id}");

        return response()->json($result);
    }

    public function stop(string $id)
    {
        $result = $this->adapter->stopContainer($id);

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['container_id' => $id])
            ->log("Container gestopt: {$id}");

        return response()->json($result);
    }

    public function delete(string $id)
    {
        $result = $this->adapter->removeContainer($id);

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['container_id' => $id])
            ->log("Container verwijderd: {$id}");

        return response()->json($result);
    }

    public function sync(Request $request)
    {
        $json = $this->adapter->listContainers();
        $service = app(ContainerSyncService::class);
        $service->sync($json);

        return response()->json(['message' => 'Containers synced']);
    }

    public function createContainer(ComposeUpRequest $request)
    {
        $yaml = Yaml::parse($request->yaml);

        $project = Project::create([
            'name' => $request->projectName,
            'user_id' => Auth::id(),
            'hash' => 'uninitialized',
            'compose_yaml' => $request->yaml,
        ]);

        foreach ($yaml['services'] as $name => $service) {
            $yaml['services'][$name]['labels']['sili.project_id'] = $project->id;
        }

        $yaml = Yaml::dump($yaml, 10);

        $payload = [
            'projectName' => $request->projectName,
            'yaml' => $yaml,
        ];

        $result = $this->adapter->createContainerFromCompose($payload);

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['project_name' => $request->projectName])
            ->log("Container aangemaakt: {$request->projectName}");

        return response()->json($result);
    }

    public function deleteContainer(ComposeUpRequest $request)
    {
        $result = $this->adapter->deleteContainerFromCompose($request->only(['projectName', 'yaml']));

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['project_name' => $request->projectName])
            ->log("Container stack verwijderd: {$request->projectName}");

        return response()->json($result);
    }
}