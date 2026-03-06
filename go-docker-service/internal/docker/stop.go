package docker

import (
	"context"

	"github.com/docker/docker/api/types/container"
)

func (s *DockerService) StopContainer(id string) error {
	ctx := context.Background()
	return s.cli.ContainerStop(ctx, id, container.StopOptions{})
}
