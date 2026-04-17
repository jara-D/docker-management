package docker

import (
	"context"
	"fmt"
)

func (s *DockerService) ServiceHealth() error {
	ctx := context.Background()

	// Ping the Docker daemon
	_, err := s.cli.Ping(ctx)
	if err != nil {
		return fmt.Errorf("docker daemon unreachable: %w", err)
	}

	return nil
}
