<?php

namespace App\Adapters;

use App\Adapters\Interface\ContainerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
     * @param array $payload
     * @return array
     */
    public function createContainerFromCompose(array $payload): array
    {
        $response = $this->client->post('/compose/up', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }


    /**
     * @param string $projectName
     * @return array
     * @throws GuzzleException
     */
    public function RemoveContainerFromCompose(string $projectName): array
    {
        $response = $this->client->post('/compose/down/' . $projectName);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return array
     */
    public function listContainers(): array
    {
        $response = $this->client->get('/container/');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $id
     * @return array
     * @throws GuzzleException
     */
    public function startContainer(string $id): array
    {
        $response = $this->client->post('/container/' . $id . '/start');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $id
     * @return array
     */
    public function stopContainer(string $id): array
    {
        $response = $this->client->post('/container/' . $id . '/stop');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $id
     * @return array
     * @throws GuzzleException
     */
    public function removeContainer(string $id): array
    {
        $response = $this->client->delete('/container/' . $id);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return array
     */
    public function listImages(): array
    {
        // TODO: Implement listImages() method.
    }
}
