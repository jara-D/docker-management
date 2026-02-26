package compose

//
//import (
//	"fmt"
//
//	"github.com/compose-spec/compose-go/types"
//	"github.com/docker/go-connections/nat"
//	"github.com/moby/moby/api/types/container"
//	"github.com/moby/moby/api/types/network"
//)
//
//func ConvertService(s types.ServiceConfig) (*container.Config, *container.HostConfig, *network.NetworkingConfig) {
//	config := &container.Config{
//		Image: s.Image,
//		Env:   convertEnvironment(s.Environment),
//	}
//
//	hostConfig := &container.HostConfig{
//		Binds:        convertVolumes(s.Volumes),
//		PortBindings: convertPorts(s.Ports),
//	}
//
//	networking := &network.NetworkingConfig{
//		EndpointsConfig: map[string]*network.EndpointSettings{},
//	}
//
//	for netName := range s.Networks {
//		networking.EndpointsConfig[netName] = &network.EndpointSettings{}
//	}
//
//	return config, hostConfig, networking
//}
//
//func convertPorts(ports []types.ServicePortConfig) nat.PortMap {
//	bindings := nat.PortMap{}
//
//	for _, p := range ports {
//		key := nat.Port(fmt.Sprintf("%d/%s", p.Target, p.Protocol))
//
//		bindings[key] = []nat.PortBinding{
//			{
//				HostIP:   "0.0.0.0",
//				HostPort: fmt.Sprintf("%d", p.Published),
//			},
//		}
//	}
//
//	return bindings
//}
//
//func convertEnvironment(env types.MappingWithEquals) []string {
//	out := []string{}
//	for key, val := range env {
//		if val == nil {
//			out = append(out, key)
//		} else {
//			out = append(out, fmt.Sprintf("%s=%s", key, *val))
//		}
//	}
//	return out
//}
//
//func convertVolumes(vols []types.ServiceVolumeConfig) []string {
//	out := []string{}
//	for _, v := range vols {
//		out = append(out, fmt.Sprintf("%s:%s", v.Source, v.Target))
//	}
//	return out
//}
