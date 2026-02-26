package docker

import (
	"github.com/docker/docker/api/types/container"
)

func DefaultListOptions() container.ListOptions {
	return container.ListOptions{All: true}
}
