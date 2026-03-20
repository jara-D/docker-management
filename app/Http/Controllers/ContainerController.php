<?php

namespace App\Http\Controllers;

use App\Adapters\Interface\ContainerInterface;
use App\Http\Requests\ComposeUpReqeust;
use App\Services\ContainerSyncService;
use Illuminate\Http\Request;

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

    public function createContainer(ComposeUpReqeust $request)
    {
        return response()->json(
            $this->adapter->createContainerFromCompose($request->only(['projectName', 'yaml']))
        );
    }
}
