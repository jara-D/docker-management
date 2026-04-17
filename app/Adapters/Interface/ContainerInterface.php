<?php

namespace App\Adapters\Interface;

// This interface lists what is possible
// This is done so we can swap the implementation easily

interface ContainerInterface
{
    public function listContainers(): array;

    public function startContainer(string $id): array;

    public function stopContainer(string $id): array;

    public function removeContainer(string $id): array;

    public function listImages(): array;

    public function createContainerFromCompose(array $payload): array;

    public function deleteContainerFromCompose(string $projectName): array;
}
