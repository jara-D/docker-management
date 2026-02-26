package compose

//
//import (
//	"context"
//	"fmt"
//	"log"
//	"strings"
//
//	"github.com/docker/cli/cli/command"
//	"github.com/docker/cli/cli/flags"
//	"github.com/docker/compose/v5/pkg/api"
//	"github.com/docker/compose/v5/pkg/compose"
//)
//
//func Up(yamlContent string) error {
//	ctx := context.Background()
//
//	dockerCLI, err := command.NewDockerCli()
//	if err != nil {
//		log.Fatalf("Failed to create docker CLI: %v", err)
//	}
//	err = dockerCLI.Initialize(&flags.ClientOptions{})
//	if err != nil {
//		log.Fatalf("Failed to initialize docker CLI: %v", err)
//	}
//
//	// Create a new Compose service instance
//	service, err := compose.NewComposeService(dockerCLI)
//	if err != nil {
//		log.Fatalf("Failed to create compose service: %v", err)
//	}
//
//	// Load the Compose project from a compose file
//	project, err := service.LoadProject(ctx, api.ProjectLoadOptions{
//		ConfigPaths: []string{"compose.yaml"},
//		ProjectName: "my-app",
//	})
//	if err != nil {
//		log.Fatalf("Failed to load project: %v", err)
//	}
//
//	// Start the services defined in the Compose file
//	err = service.Up(ctx, project, api.UpOptions{
//		Create: api.CreateOptions{},
//		Start:  api.StartOptions{},
//	})
//	if err != nil {
//		log.Fatalf("Failed to start services: %v", err)
//	}
//
//	log.Printf("Successfully started project: %s", project.Name)
//
//	//ctx := context.Background()
//	//
//	//// 1. Parse YAML into our minimal model
//	//var cfg ComposeFile
//	//if err := yaml.Unmarshal([]byte(yamlContent), &cfg); err != nil {
//	//	return fmt.Errorf("failed to parse compose yaml: %w", err)
//	//}
//	//
//	//if len(cfg.Services) == 0 {
//	//	return fmt.Errorf("no services defined in compose file")
//	//}
//	//
//	//// 2. Docker client
//	//docker, err := client.NewClientWithOpts(client.FromEnv)
//	//if err != nil {
//	//	return fmt.Errorf("failed to create docker client: %w", err)
//	//}
//	//
//	//// 3. Loop services → create + start containers
//	//for name, svc := range cfg.Services {
//	//	log.Printf("Creating service %s (image: %s)\n", name, svc.Image)
//	//
//	//	// Convert environment
//	//	env := make([]string, 0, len(svc.Env))
//	//	for k, v := range svc.Env {
//	//		env = append(env, fmt.Sprintf("%s=%s", k, v))
//	//	}
//	//
//	//	// Convert ports
//	//	portBindings, exposedPorts, err := parsePorts(svc.Ports)
//	//	if err != nil {
//	//		return fmt.Errorf("invalid ports for service %s: %w", name, err)
//	//	}
//	//
//	//	config := &container.Config{
//	//		Image:        svc.Image,
//	//		Env:          env,
//	//		ExposedPorts: exposedPorts,
//	//	}
//	//
//	//	hostConfig := &container.HostConfig{
//	//		PortBindings: portBindings,
//	//		Binds:        svc.Volumes,
//	//	}
//	//
//	//	networking := &network.NetworkingConfig{}
//	//
//	//	// FIXED: use svc.Image, not service.Image
//	//	if err := pullImageIfNeeded(ctx, docker, svc.Image); err != nil {
//	//		return err
//	//	}
//	//
//	//	// Create container
//	//	resp, err := docker.ContainerCreate(ctx, client.ContainerCreateOptions{
//	//		Config:           config,
//	//		HostConfig:       hostConfig,
//	//		NetworkingConfig: networking,
//	//	})
//	//	if err != nil {
//	//		return fmt.Errorf("failed to create container for service %s: %w", name, err)
//	//	}
//	//
//	//	log.Printf("Starting container %s (%s)\n", name, resp.ID)
//	//
//	//	// Start container
//	//	_, err = docker.ContainerStart(ctx, resp.ID, client.ContainerStartOptions{})
//	//	if err != nil {
//	//		return fmt.Errorf("failed to start container: %w", err)
//	//	}
//	//
//	//}
//	//
//	//return nil
//}
//
//func parsePorts(ports []string) (network.PortMap, network.PortSet, error) {
//	bindings := network.PortMap{}
//	exposed := network.PortSet{}
//
//	for _, p := range ports {
//		parts := strings.Split(p, ":")
//		if len(parts) != 2 {
//			return nil, nil, fmt.Errorf("invalid port format: %s", p)
//		}
//
//		hostPort := parts[0]
//		containerPort := parts[1]
//
//		// ✔ Correct: use ParsePort
//		port, err := network.ParsePort(containerPort + "/tcp")
//		if err != nil {
//			return nil, nil, err
//		}
//
//		exposed[port] = struct{}{}
//		bindings[port] = []network.PortBinding{
//			{HostPort: hostPort},
//		}
//	}
//
//	return bindings, exposed, nil
//}
