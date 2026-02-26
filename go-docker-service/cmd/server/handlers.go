package main

import (
	"go-docker-service/internal/docker"
	"net/http"

	"github.com/gin-gonic/gin"
)

//	type ComposeRequest struct {
//		Yaml string `json:"yaml"`
//	}
//
//	func UpHandler(c *gin.Context) {
//		var req ComposeRequest
//
//		if err := c.BindJSON(&req); err != nil {
//			c.JSON(http.StatusBadRequest, gin.H{"error": "invalid JSON"})
//			return
//		}
//
//		if req.Yaml == "" {
//			c.JSON(http.StatusBadRequest, gin.H{"error": "missing yaml field"})
//			return
//		}
//
//		if err := compose.Up(req.Yaml); err != nil {
//			c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
//			return
//		}
//
//		c.JSON(http.StatusOK, gin.H{"status": "OK"})
//	}
//
//	func DownHandler(c *gin.Context) {
//		var req ComposeRequest
//
//		if err := c.BindJSON(&req); err != nil {
//			c.JSON(http.StatusBadRequest, gin.H{"error": "invalid JSON"})
//			return
//		}
//
//		if req.Yaml == "" {
//			c.JSON(http.StatusBadRequest, gin.H{"error": "missing yaml field"})
//			return
//		}
//
//		if err := compose.Down(req.Yaml); err != nil {
//			c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
//			return
//		}
//
//		c.JSON(http.StatusOK, gin.H{"status": "OK"})
//	}
//
//	func HealthHandler(c *gin.Context) {
//		if err := internal.CheckHealth(); err != nil {
//			c.JSON(http.StatusServiceUnavailable, gin.H{
//				"status": "unhealthy",
//				"error":  err.Error(),
//			})
//			log.Printf("health check failed")
//			return
//		}
//
//		c.JSON(http.StatusOK, gin.H{"status": "healthy"})
//	}
func respond(c *gin.Context, err error, ok interface{}) {
	if err != nil {
		c.JSON(http.StatusServiceUnavailable, gin.H{"error": err.Error()})
		return
	}
	c.JSON(http.StatusOK, ok)
}

func health(c *gin.Context) {

}

func list(c *gin.Context, svc *docker.DockerService) {
	containers, err := svc.ListContainers()
	respond(c, err, containers)
}

func start(c *gin.Context, svc *docker.DockerService) {
	id := c.Param("id")
	err := svc.StartContainer(id)
	respond(c, err, gin.H{"status": "started"})
}

func stop(c *gin.Context, svc *docker.DockerService) {
	id := c.Param("id")
	err := svc.StopContainer(id)
	respond(c, err, gin.H{"status": "stopped"})
}

func restart(c *gin.Context, svc *docker.DockerService) {
	id := c.Param("id")
	err := svc.RestartContainer(id)
	respond(c, err, gin.H{"status": "restarted"})
}

func remove(c *gin.Context, svc *docker.DockerService) {
	id := c.Param("id")
	err := svc.RemoveContainer(id)
	respond(c, err, gin.H{"status": "removed"})
}

func ServiceHealth(c *gin.Context, svc *docker.DockerService) {
	err := svc.ServiceHealth()
	respond(c, err, gin.H{"status": "ok"})
}
