package compose

import (
	"context"
	"fmt"
	"io"

	"github.com/docker/docker/api/types/image"
	"github.com/docker/docker/client"
)

func pullImageIfNeeded(ctx context.Context, cli *client.Client, imageName string) error {
	// Check if image exists using ImageList (NOT deprecated)
	images, err := cli.ImageList(ctx, image.ListOptions{})
	if err != nil {
		return fmt.Errorf("failed to list images: %w", err)
	}

	for _, img := range images {
		for _, tag := range img.RepoTags {
			if tag == imageName {
				return nil // image exists
			}
		}
	}

	// Pull image if not found
	fmt.Println("Pulling image:", imageName)

	reader, err := cli.ImagePull(ctx, imageName, image.PullOptions{})
	if err != nil {
		return fmt.Errorf("failed to pull image %s: %w", imageName, err)
	}
	defer reader.Close()

	// Drain the stream
	_, _ = io.Copy(io.Discard, reader)

	return nil
}
