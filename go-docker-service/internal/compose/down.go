package compose

import (
	"context"

	"github.com/docker/compose/v5/pkg/api"
)

func (cw *ComposeWrapper) Down(projectName string) error {
	ctx := context.Background()

	return cw.cs.Down(ctx, projectName, api.DownOptions{
		RemoveOrphans: true,
		Volumes:       true,
		Images:        "all",
	})
}
