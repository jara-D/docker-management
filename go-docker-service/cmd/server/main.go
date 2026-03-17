package main

import (
    "go-docker-service/internal/compose"
    "go-docker-service/internal/docker"

    "github.com/gin-gonic/gin"
)

func main() {
    svc, err := docker.NewDockerService("")
    cw, err := compose.NewComposeWrapper()
    if err != nil {
        panic(err)
    }
    defer svc.Close()

    r := setupRouter(svc, cw)
    r.SetTrustedProxies([]string{"172.16.0.0/12"})
    r.Run(":8080")

}

func setupRouter(svc *docker.DockerService, cw *compose.ComposeWrapper) *gin.Engine {
    r := gin.Default()

    h := &Handler{
        svc: svc,
        cw:  cw,
    }

    r.GET("/", h.ServiceHealth)

    container := r.Group("/container")
    {
        container.GET("/", h.list)
        container.POST("/:id/start", h.start)
        container.POST("/:id/stop", h.stop)
        container.POST("/:id/restart", h.restart)
        container.DELETE("/:id", h.remove)
    }

    composeGroup := r.Group("/compose")
    {
        composeGroup.POST("/up", h.Up)
        composeGroup.POST("/down/:project", h.Down)
    }

    return r
}
