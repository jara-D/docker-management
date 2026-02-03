<?php

namespace App\Http\Controllers;

use App\Services\ContainerSyncService;
use Illuminate\Http\Request;
use App\Adapters\ContainerInterface;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sync(Request $request)
    {
        $json = $this->adapter->listContainers();
        $service = app(ContainerSyncService::class);
        $service->sync($json);

        return response()->json(['message' => 'Containers synced']);

    }
}
