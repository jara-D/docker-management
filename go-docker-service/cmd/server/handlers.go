package main

import (
    "go-docker-service/internal/compose"
    "go-docker-service/internal/docker"
    "net/http"

    "github.com/gin-gonic/gin"
)

type Handler struct {
    svc *docker.DockerService
    cw  *compose.ComposeWrapper
}

type ComposeRequest struct {
    ProjectName string `json:"projectName" binding:"required"`
    Yaml        string `json:"yaml" binding:"required"`
}

func (h *Handler) Up(c *gin.Context) {
    var req ComposeRequest

    if err := c.BindJSON(&req); err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{"message": "invalid JSON"},
        })
        return
    }

    if req.Yaml == "" || req.ProjectName == "" {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{"message": "yaml and projectName are required"},
        })
        return
    }

    if err := h.cw.Up(req.Yaml, req.ProjectName); err != nil {
        respond(c, http.StatusInternalServerError, gin.H{
            "error": gin.H{
                "message": "failed to start compose project",
                "details": err.Error(),
            },
        })
        return
    }

    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state":       "up",
            "projectName": req.ProjectName,
        },
    })
}

func (h *Handler) Down(c *gin.Context) {
    projectName := c.Param("project")

    if projectName == "" {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{"message": "project name is required"},
        })
        return
    }

    exists, err := h.svc.ProjectExists(projectName)
    if err != nil {
        respond(c, http.StatusInternalServerError, gin.H{
            "error": gin.H{"message": "failed to check project existence"},
        })
        return
    }

    if !exists {
        respond(c, http.StatusNotFound, gin.H{
            "error": gin.H{"message": "project does not exist"},
        })
        return
    }

    if err := h.cw.Down(projectName); err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{
                "message": "failed to bring down compose project",
                "details": err.Error(),
            },
        })
        return
    }

    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state":       "down",
            "projectName": projectName,
        },
    })
}

func respond(c *gin.Context, status int, payload interface{}) {
    c.JSON(status, payload)
}

func (h *Handler) list(c *gin.Context) {
    data, err := h.svc.ListContainers()
    if err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{
                "message": "failed to retrieve containers",
                "details": err.Error(),
            },
        })
        return
    }

    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state": "success",
            "data":  data,
        },
    })
}

func (h *Handler) start(c *gin.Context) {
    id := c.Param("id")

    if err := h.svc.StartContainer(id); err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{
                "message": "failed to start container",
                "details": err.Error(),
            },
        })
        return
    }

    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state": "started",
            "id":    id,
        },
    })
}

func (h *Handler) stop(c *gin.Context) {
    id := c.Param("id")
    if err := h.svc.StopContainer(id); err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{
                "message": "failed to stop container",
                "details": err.Error(),
            },
        })
        return
    }

    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state": "stopped",
            "id":    id,
        },
    })
}

func (h *Handler) restart(c *gin.Context) {
    id := c.Param("id")
    if err := h.svc.RestartContainer(id); err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{
                "message": "failed to restart container",
                "details": err.Error(),
            },
        })
        return
    }

    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state": "restarted",
            "id":    id,
        },
    })

}

func (h *Handler) remove(c *gin.Context) {
    id := c.Param("id")
    if err := h.svc.RemoveContainer(id); err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{
                "message": "failed to remove container",
                "details": err.Error(),
            },
        })
        return
    }

    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state": "removed",
            "id":    id,
        },
    })

}

func (h *Handler) ServiceHealth(c *gin.Context) {
    if err := h.svc.ServiceHealth(); err != nil {
        respond(c, http.StatusBadRequest, gin.H{
            "error": gin.H{
                "message": "health check failed",
                "details": err.Error(),
            },
        })
        return
    }
    respond(c, http.StatusOK, gin.H{
        "result": gin.H{
            "state": "healthy",
        },
    })
}
