package docker

import "github.com/docker/docker/client"

type DockerService struct {
	cli *client.Client
}

// NewDockerService Creates a long-lived docker client
func NewDockerService(host string) (*DockerService, error) {
	opts := []client.Opt{
		client.WithAPIVersionNegotiation(),
	}

	if host != "" {
		opts = append(opts, client.WithHost(host))
	} else {
		opts = append(opts, client.FromEnv)
	}

	cli, err := client.NewClientWithOpts(opts...)
	if err != nil {
		return nil, err
	}

	return &DockerService{cli: cli}, nil
}

func (s *DockerService) Close() error {
	return s.cli.Close()
}

func (s *DockerService) Client() *client.Client { return s.cli }

// NewDockerServiceTLS untested
func NewDockerServiceTLS(host, ca, cert, key string) (*DockerService, error) {
	opts := []client.Opt{
		client.WithHost(host),
		client.WithTLSClientConfig(ca, cert, key),
		client.WithAPIVersionNegotiation(),
	}

	cli, err := client.NewClientWithOpts(opts...)
	if err != nil {
		return nil, err
	}

	return &DockerService{cli: cli}, nil
}
