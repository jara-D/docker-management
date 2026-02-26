package docker

import (
    "context"

    "github.com/docker/docker/api/types/container"
)

func (s *DockerService) RestartContainer(id string) error {
    ctx := context.Background()
    return s.cli.ContainerRestart(ctx, id, container.StopOptions{})
}
