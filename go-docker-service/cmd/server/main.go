package main

import (
    "go-docker-service/internal/docker"

    "github.com/gin-gonic/gin"
)

func main() {
    svc, err := docker.NewDockerService("")
    if err != nil {
        panic(err)
    }
    defer svc.Close()

    router := setupRouter(svc)
    router.Run()

}

func setupRouter(svc *docker.DockerService) *gin.Engine {
    r := gin.Default()

    r.GET("/", wrap(svc, ServiceHealth))

    {
        container := r.Group("/container")
        container.GET("/list", wrap(svc, list))
        container.GET("/start/:id", wrap(svc, start))
        container.GET("/stop/:id", wrap(svc, stop))
        container.GET("/restart/:id", wrap(svc, restart))
        container.GET("/remove/:id", wrap(svc, remove))
    }

    return r
}

func wrap(svc *docker.DockerService, fn func(*gin.Context, *docker.DockerService)) gin.HandlerFunc {
    return func(c *gin.Context) { fn(c, svc) }
}
