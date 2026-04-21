<?php

namespace App\Services;

use App\Models\Container;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class ContainerSyncService
{
    public function sync(array $data): void
    {
        $items = $data['result']['data'] ?? [];

        if (empty($items)) {
            return;
        }

        // Extract container IDs from Docker
        $incomingIds = collect($items)->pluck('Id')->filter()->values()->toArray();

        // Delete containers that no longer exist in Docker
        Container::whereNotIn('container_id', $incomingIds)->delete();

        // Group containers by managed/unmanaged/compose/standalone
        $groups = collect($items)->groupBy(function ($item) {

            // Managed (Sili)
            if (isset($item['Labels']['sili.project_id'])) {
                return 'managed:' . $item['Labels']['sili.project_id'];
            }

            // Unmanaged Docker Compose
            if (isset($item['Labels']['com.docker.compose.project'])) {
                return 'unmanaged:' . $item['Labels']['com.docker.compose.project'];
            }

            // Standalone unmanaged
            return 'unmanaged:' . ($item['Names'][0] ?? 'unknown');
        });

        foreach ($groups as $groupKey => $containers) {

            if (str_starts_with($groupKey, 'managed:')) {

                $projectId = (int) str_replace('managed:', '', $groupKey);
                $project = Project::find($projectId);

                if (!$project) continue;

                $project->update([
                    'type' => 'managed',
                    'hash' => $this->computeProjectHash($project->name, $containers),
                ]);
            }

            else {
                // Unmanaged project name
                $projectName = str_replace('unmanaged:', '', $groupKey);

                $project = Project::firstOrCreate(
                    ['name' => $projectName],
                    [
                        'type' => 'unmanaged',
                        'user_id' => 1,
                        'compose_yaml' => null,
                        'hash' => null,
                    ]
                );
            }

            // Sync containers
            foreach ($containers as $item) {
                Container::updateOrCreate(
                    ['container_id' => $item['Id']],
                    [
                        'project_id' => $project->id,
                        'name' => $item['Labels']['com.docker.compose.service'] ?? null,
                        'image' => $item['Image'] ?? null,
                        'image_id' => $item['ImageID'] ?? null,
                        'state' => $item['State'] ?? null,
                        'status' => $item['Status'] ?? null,
                        'ports' => $item['Ports'] ?? [],
                        'labels' => $item['Labels'] ?? [],
                        'network_settings' => $item['NetworkSettings'] ?? null,
                        'mounts' => $item['Mounts'] ?? null,
                    ]
                );
            }
        }
    }

    public function projectSync(string $projectId, array $dockerContainers): void
    {
        // Extract the real container list
        $dockerContainers = $dockerContainers['result']['data'] ?? [];

        // Load project with containers
        $project = Project::with('containers')->find($projectId);

        if (!$project) {
            return;
        }

        // Index docker data by container ID
        $dockerIndex = collect($dockerContainers)->keyBy('Id');

        foreach ($project->containers as $container) {

            if (!$dockerIndex->has($container->container_id)) {
                Log::info("No docker data for {$container->container_id}");
                continue;
            }

            $data = $dockerIndex[$container->container_id];

            $container->update([
                'state'  => $data['State']  ?? $container->state,
                'status' => $data['Status'] ?? $container->status,
            ]);
        }
    }



    /**
     * Compute a stable hash for a project based on its containers.
     */
    private function computeProjectHash(string $projectName, $containers): string
    {
        $ids = $containers->pluck('Id')->sort()->implode('');
        $dirs = $containers->pluck('Labels.com.docker.compose.project.working_dir')->sort()->implode('');
        $projectIds = $containers->pluck('Labels.sili.project_id')->sort()->implode('');

        return hash('sha256', $projectName . $ids . $dirs . $projectIds);
    }
}
