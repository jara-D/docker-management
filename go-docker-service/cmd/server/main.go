package main

import (
	"log"
	"net/http"
)

func main() {
    http.HandleFunc("/health", health)
	http.HandleFunc("/compose/up", handleUp)
	http.HandleFunc("/compose/down", handleDown)

	log.Println("Go Docker Service running on :8081")
	http.ListenAndServe(":8081", nil)
}
