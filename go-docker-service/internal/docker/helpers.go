package docker

import (
	"context"
	"fmt"

	"github.com/docker/docker/api/types/container"
	"github.com/docker/docker/api/types/filters"
)

func DefaultListOptions() container.ListOptions {
	return container.ListOptions{All: true}
}

func (s *DockerService) ProjectExists(projectName string) (bool, error) {
	ctx := context.Background()
	// List all containers matching the project label
	opts := container.ListOptions{
		Filters: filters.NewArgs(
			filters.KeyValuePair{Key: "label", Value: fmt.Sprintf("com.docker.compose.project=%s", projectName)},
		),
	}
	containers, err := s.cli.ContainerList(ctx, opts)
	if err != nil {
		return false, fmt.Errorf("failed to list containers for project %q: %w", projectName, err)
	}

	return len(containers) > 0, nil
}
