package docker

import (
	"context"

	"github.com/docker/docker/api/types/container"
)

func (s *DockerService) RemoveContainer(id string) error {
	ctx := context.Background()
	return s.cli.ContainerRemove(ctx, id, container.RemoveOptions{})
}
