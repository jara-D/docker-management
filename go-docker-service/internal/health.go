package internal

import (
	"fmt"
	"github.com/docker/docker/client"
)

func CheckHealth() error {
	_, err := client.NewClientWithOpts(client.FromEnv)
	if err != nil {
		return fmt.Errorf("failed to create docker client: %w", err)
	}
	return nil
}
