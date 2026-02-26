package compose

//
//import (
//	"context"
//	"fmt"
//	"log"
//
//	"gopkg.in/yaml.v3"
//
//	"github.com/moby/moby/client"
//)
//
//func Down(yamlContent string) error {
//	ctx := context.Background()
//
//	var cfg ComposeFile
//	if err := yaml.Unmarshal([]byte(yamlContent), &cfg); err != nil {
//		return fmt.Errorf("failed to parse compose yaml: %w", err)
//	}
//
//	if len(cfg.Services) == 0 {
//		return fmt.Errorf("no services defined in compose file")
//	}
//
//	cli, err := client.NewClientWithOpts(client.FromEnv)
//	if err != nil {
//		return fmt.Errorf("failed to create docker client: %w", err)
//	}
//	defer cli.Close()
//
//	for name := range cfg.Services {
//		log.Printf("Stopping container %s\n", name)
//
//		_, _ = cli.ContainerStop(ctx, name, client.ContainerStopOptions{})
//
//		log.Printf("Removing container %s\n", name)
//
//		_, err := cli.ContainerRemove(ctx, name, client.ContainerRemoveOptions{})
//
//		if err != nil {
//			return fmt.Errorf("failed to remove container %s: %w", name, err)
//		}
//	}
//
//	return nil
//}
