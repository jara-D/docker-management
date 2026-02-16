package compose

import (
	"context"
	"fmt"
	"log"

	"gopkg.in/yaml.v3"

	"github.com/docker/docker/api/types/container"
	"github.com/docker/docker/client"
)

func Down(yamlContent string) error {
	ctx := context.Background()

	// Parse YAML
	var cfg ComposeFile
	if err := yaml.Unmarshal([]byte(yamlContent), &cfg); err != nil {
		return fmt.Errorf("failed to parse compose yaml: %w", err)
	}

	if len(cfg.Services) == 0 {
		return fmt.Errorf("no services defined in compose file")
	}

	// Docker client
	docker, err := client.NewClientWithOpts(client.FromEnv)
	if err != nil {
		return fmt.Errorf("failed to create docker client: %w", err)
	}

	// Loop services → stop + remove containers
	for name := range cfg.Services {
		log.Printf("Stopping container %s\n", name)

		// Stop container (ignore error if it's already stopped)
		_ = docker.ContainerStop(ctx, name, container.StopOptions{})

		log.Printf("Removing container %s\n", name)

		// Remove container
		err := docker.ContainerRemove(ctx, name, container.RemoveOptions{
			Force: true,
		})
		if err != nil {
			return fmt.Errorf("failed to remove container %s: %w", name, err)
		}
	}

	return nil
}
