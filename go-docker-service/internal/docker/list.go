package docker

import (
	"context"

	"github.com/docker/docker/api/types/container"
)

func (s *DockerService) ListContainers() ([]container.Summary, error) {
	opts := DefaultListOptions()
	return s.cli.ContainerList(context.Background(), opts)
}
