package main

import (
    "log"
    "net/http"

    "go-docker-service/internal"
    "go-docker-service/internal/compose"

    "github.com/gin-gonic/gin"
)

type ComposeRequest struct {
    Yaml string `json:"yaml"`
}

func UpHandler(c *gin.Context) {
    var req ComposeRequest

    if err := c.BindJSON(&req); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "invalid JSON"})
        return
    }

    if req.Yaml == "" {
        c.JSON(http.StatusBadRequest, gin.H{"error": "missing yaml field"})
        return
    }

    if err := compose.Up(req.Yaml); err != nil {
        c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
        return
    }

    c.JSON(http.StatusOK, gin.H{"status": "OK"})
}

func DownHandler(c *gin.Context) {
    var req ComposeRequest

    if err := c.BindJSON(&req); err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": "invalid JSON"})
        return
    }

    if req.Yaml == "" {
        c.JSON(http.StatusBadRequest, gin.H{"error": "missing yaml field"})
        return
    }

    if err := compose.Down(req.Yaml); err != nil {
        c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
        return
    }

    c.JSON(http.StatusOK, gin.H{"status": "OK"})
}

func HealthHandler(c *gin.Context) {
    if err := internal.CheckHealth(); err != nil {
        c.JSON(http.StatusServiceUnavailable, gin.H{
            "status": "unhealthy",
            "error":  err.Error(),
        })
        log.Printf("health check failed")
        return
    }

    c.JSON(http.StatusOK, gin.H{"status": "healthy"})
}
