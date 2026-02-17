package main

import (
	"log"

	"github.com/gin-gonic/gin"
)

func main() {
	router := gin.Default()
	router.GET("/health", HealthHandler)
	router.POST("/compose/up", DownHandler)
	router.POST("/compose/down", UpHandler)

	log.Println("Go Docker Service running on :8081")
	err := router.Run("localhost:8081")
	if err != nil {
		return
	}
}
