<?php

namespace App\Services;

use App\Models\Container;

class ContainerSyncService
{
    public function sync(array $data): void
    {

        $data = $data['result']['data'];
        foreach ($data as $item) {
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
