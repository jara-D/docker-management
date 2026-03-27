<?php

namespace App\Services;

use App\Models\Container;
use App\Models\Project;
use Auth;

class ContainerSyncService
{
    public function sync(array $data): void
    {
        $items = $data['result']['data'];

        $incomingIds = collect($items)->pluck('Id')->toArray();

        Container::whereNotIn('container_id', $incomingIds)->delete();

        $groups = collect($items)->groupBy(function ($item) {
            return $item['Labels']['com.docker.compose.project'] ?? 'unknown';
        });

        foreach ($groups as $projectName => $containers) {

            $hashInput = $projectName
                . implode('', collect($containers)->pluck('Id')->sort()->toArray())
                . implode('', collect($containers)->pluck('Labels.com.docker.compose.project.working_dir')->sort()->toArray());

            $projectHash = hash('sha256', $hashInput);

            $owners = collect($containers)
                ->pluck('Labels.sili.owner')
                ->filter()
                ->unique();

            $projectOwner = $owners->first() ?? auth()->id();



            $project = Project::updateOrCreate(
                ['hash' => $projectHash],
                [
                    'name' => $projectName,
                    'user_id' => $projectOwner,
                ]
            );


            foreach ($containers as $item) {
                Container::updateOrCreate(
                    ['container_id' => $item['Id']],
                    [
                        'project_id' => $project->id,
                        'name' => $item['Names'][0] ?? null,
                        'image' => $item['Image'],
                        'image_id' => $item['ImageID'],
                        'state' => $item['State'],
                        'status' => $item['Status'],
                        'ports' => $item['Ports'],
                        'labels' => $item['Labels'],
                        'network_settings' => $item['NetworkSettings'] ?? null,
                        'mounts' => $item['Mounts'] ?? null,
                    ]
                );
            }
        }
    }
}
