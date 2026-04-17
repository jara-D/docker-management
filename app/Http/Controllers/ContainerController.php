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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // List all containers
        return response()->json($this->adapter->listContainers());
    }

    public function start(string $id)
    {
        return response()->json($this->adapter->startContainer($id));
    }

    public function stop(string $id)
    {
        return response()->json($this->adapter->stopContainer($id));
    }

    public function delete(string $id)
    {
        return response()->json($this->adapter->removeContainer($id));
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

        // Put the id of the project into the container for identification
        foreach ($yaml['services'] as $name => $service) {
            $yaml['services'][$name]['labels']['sili.project_id'] = $project->id;
        }

        $yaml = Yaml::dump($yaml, 10);

        $payload = [
            'projectName' => $request->projectName,
            'yaml' => $yaml,
        ];

        return response()->json(
            $this->adapter->createContainerFromCompose($payload)
        );
    }

    public function deleteContainer(ComposeUpRequest $request)
    {
        return response()->json(
            $this->adapter->deleteContainerFromCompose($request->only(['projectName', 'yaml']))
        );
    }
}
