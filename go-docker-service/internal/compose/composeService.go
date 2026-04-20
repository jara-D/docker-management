package compose

import (
	"github.com/docker/cli/cli/command"
	"github.com/docker/cli/cli/flags"
	"github.com/docker/compose/v5/pkg/api"
	"github.com/docker/compose/v5/pkg/compose"
)

type ComposeWrapper struct {
	cli *command.DockerCli
	cs  api.Compose
}

func NewComposeWrapper() (*ComposeWrapper, error) {
	cli, err := command.NewDockerCli()
	if err != nil {
		return nil, err
	}
	if err := cli.Initialize(flags.NewClientOptions()); err != nil {
		return nil, err
	}

	cs, err := compose.NewComposeService(cli)
	if err != nil {
		return nil, err
	}

	return &ComposeWrapper{cli: cli, cs: cs}, nil
}
