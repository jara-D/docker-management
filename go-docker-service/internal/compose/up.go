package compose

import (
	"context"
	"fmt"
	"log"
	"strings"

	"gopkg.in/yaml.v3"

	"github.com/docker/docker/api/types/container"
	"github.com/docker/docker/api/types/network"
	"github.com/docker/docker/client"
	"github.com/docker/go-connections/nat"
)

func Up(yamlContent string) error {
	ctx := context.Background()

	// 1. Parse YAML into our minimal model
	var cfg ComposeFile
	if err := yaml.Unmarshal([]byte(yamlContent), &cfg); err != nil {
		return fmt.Errorf("failed to parse compose yaml: %w", err)
	}

	if len(cfg.Services) == 0 {
		return fmt.Errorf("no services defined in compose file")
	}

	// 2. Docker client
	docker, err := client.NewClientWithOpts(client.FromEnv)
	if err != nil {
		return fmt.Errorf("failed to create docker client: %w", err)
	}

	// 3. Loop services → create + start containers
	for name, svc := range cfg.Services {
		log.Printf("Creating service %s (image: %s)\n", name, svc.Image)

		// Convert environment
		env := make([]string, 0, len(svc.Env))
		for k, v := range svc.Env {
			env = append(env, fmt.Sprintf("%s=%s", k, v))
		}

		// Convert ports
		portBindings, exposedPorts, err := parsePorts(svc.Ports)
		if err != nil {
			return fmt.Errorf("invalid ports for service %s: %w", name, err)
		}

		config := &container.Config{
			Image:        svc.Image,
			Env:          env,
			ExposedPorts: exposedPorts,
		}

		hostConfig := &container.HostConfig{
			PortBindings: portBindings,
			Binds:        svc.Volumes,
		}

		networking := &network.NetworkingConfig{}

		// FIXED: use svc.Image, not service.Image
		if err := pullImageIfNeeded(ctx, docker, svc.Image); err != nil {
			return err
		}

		// Create container
		resp, err := docker.ContainerCreate(ctx, config, hostConfig, networking, nil, name)
		if err != nil {
			return fmt.Errorf("failed to create container for service %s: %w", name, err)
		}

		log.Printf("Starting container %s (%s)\n", name, resp.ID)

		// Start container
		if err := docker.ContainerStart(ctx, resp.ID, container.StartOptions{}); err != nil {
			return fmt.Errorf("failed to start container for service %s: %w", name, err)
		}
	}

	return nil
}

func parsePorts(ports []string) (nat.PortMap, nat.PortSet, error) {
	bindings := nat.PortMap{}
	exposed := nat.PortSet{}

	for _, p := range ports {
		// format: "HOST:CONTAINER" e.g. "8080:80"
		port, err := nat.NewPort("tcp", p[strings.Index(p, ":")+1:])
		if err != nil {
			return nil, nil, err
		}

		hostPort := p[:strings.Index(p, ":")]

		exposed[port] = struct{}{}
		bindings[port] = []nat.PortBinding{
			{HostPort: hostPort},
		}
	}

	return bindings, exposed, nil
}
