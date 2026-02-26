<?php

namespace App\Adapters;

use App\Adapters\Interface\ContainerInterface;
use GuzzleHttp\Client;

class GoServiceAdapter implements ContainerInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://go-service:8080',
        ]);
    }

    /**
     * @param string $Yaml
     * @return bool
     */
    public function createContainerFromCompose(string $Yaml): bool
    {
        $response = $this->client->post('/compose/up');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function RemoveContainerFromCompose(string $id): bool
    {
        $response = $this->client->post('/compose/down');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return array
     */
    public function listContainers(): array
    {
        $response = $this->client->get('/container/list');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function startContainer(string $id): bool
    {
        // TODO: Implement startContainer() method.
    }

    /**
     * @param string $id
     * @return bool
     */
    public function stopContainer(string $id): bool
    {
        // TODO: Implement stopContainer() method.
    }

    /**
     * @param string $id
     * @return bool
     */
    public function removeContainer(string $id): bool
    {
        // TODO: Implement removeContainer() method.
    }

    /**
     * @return array
     */
    public function listImages(): array
    {
        // TODO: Implement listImages() method.
    }
}
