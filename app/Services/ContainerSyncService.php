<?php

namespace App\Services;

use App\Models\Container;

class ContainerSyncService
{
    public function sync(array $data): void
    {
        $items = $data['result']['data'];

        // 1. Collect all container IDs from the incoming data
        $incomingIds = collect($items)->pluck('Id')->toArray();

        // 2. Delete containers that no longer exist
        Container::whereNotIn('container_id', $incomingIds)->delete();

        // 3. Update or create existing containers
        foreach ($items as $item) {
            Container::updateOrCreate(
                ['container_id' => $item['Id']],
                [
                    'name' => $item['Names'][0] ?? null,
                    'image' => $item['Image'],
                    'image_id' => $item['ImageID'],
                    'state' => $item['State'],
                    'status' => $item['Status'],
                    'ports' => $item['Ports'],
                    'labels' => $item['Labels'],
                    'network_settings' => $item['NetworkSettings'],
                    'mounts' => $item['Mounts'],
                ]
            );
        }
    }
}
