<?php

namespace App\Adapters\Interface;

// This interface lists what is possible
// This is done so we can swap the implementation easily

interface ContainerInterface
{
    public function listContainers(): array;

    public function startContainer(string $id): bool;

    public function stopContainer(string $id): bool;

    public function removeContainer(string $id): bool;

    public function listImages(): array;

    public function createContainerFromCompose(string $Yaml): bool;
}
