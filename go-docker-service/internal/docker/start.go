package docker

import (
	"context"

	"github.com/docker/docker/api/types/container"
)

func (s *DockerService) StartContainer(id string) error {
	ctx := context.Background()
	return s.cli.ContainerStart(ctx, id, container.StartOptions{})
}
