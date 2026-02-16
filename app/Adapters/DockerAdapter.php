<?php

namespace App\Adapters;

// This interface is for implementing the functionality

use App\Adapters\Interface\ContainerInterface;
use GuzzleHttp\Client;

class DockerAdapter implements ContainerInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost', // required, but not actually used
            'curl' => [
                CURLOPT_UNIX_SOCKET_PATH => '/var/run/docker.sock',
            ],
        ]);
    }

    public function listContainers(): array
    {
        $response = $this->client->get('/containers/json');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function startContainer(string $id): bool
    {
        $response = $this->client->post("/containers/{$id}/start");
        return $response->getStatusCode() === 204;
    }

    public function stopContainer(string $id): bool
    {
        $response = $this->client->post("/containers/{$id}/stop");
        return $response->getStatusCode() === 204;
    }

    public function removeContainer(string $id): bool
    {
        $response = $this->client->delete("/containers/{$id}");
        return $response->getStatusCode() === 204;
    }

    public function listImages(): array
    {
        $response = $this->client->get('/images/json');
        return json_decode($response->getBody()->getContents(), true);
    }
}
