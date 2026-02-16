package compose

type ComposeFile struct {
	Services map[string]Service `yaml:"services"`
}

type Service struct {
	Image   string            `yaml:"image"`
	Ports   []string          `yaml:"ports"` // "8080:80"
	Env     map[string]string `yaml:"environment"`
	Volumes []string          `yaml:"volumes"` // "/host:/container"
}
