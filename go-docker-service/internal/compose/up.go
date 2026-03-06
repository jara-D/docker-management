package compose

import (
	"context"
	"fmt"
	"os"
	"path/filepath"
	"time"

	"github.com/docker/compose/v5/pkg/api"
)

func (cw *ComposeWrapper) Up(yamlContent, projectName string) error {
	ctx := context.Background()

	// Write YAML to temp file
	path := filepath.Join(os.TempDir(), fmt.Sprintf("compose_%d.yaml", time.Now().UnixNano()))
	if err := os.WriteFile(path, []byte(yamlContent), 0600); err != nil {
		return fmt.Errorf("failed to write compose file: %w", err)
	}
	defer os.Remove(path)

	// Load project
	project, err := cw.cs.LoadProject(ctx, api.ProjectLoadOptions{
		ConfigPaths: []string{path},
		ProjectName: projectName,
	})
	if err != nil {
		return fmt.Errorf("invalid compose project: %w", err)
	}

	// Bring up
	return cw.cs.Up(ctx, project, api.UpOptions{
		Create: api.CreateOptions{},
		Start:  api.StartOptions{},
	})
}
