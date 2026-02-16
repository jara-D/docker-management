package main

import (
	"encoding/json"
	"io"
	"net/http"

	"go-docker-service/internal/compose"
)

type UpRequest struct {
	Yaml string `json:"yaml"`
}

func handleUp(w http.ResponseWriter, r *http.Request) {
	body, _ := io.ReadAll(r.Body)

	var req UpRequest
	if err := json.Unmarshal(body, &req); err != nil {
		http.Error(w, "invalid JSON", 400)
		return
	}

	if req.Yaml == "" {
		http.Error(w, "missing yaml field", 400)
		return
	}

	if err := compose.Up(req.Yaml); err != nil {
		http.Error(w, err.Error(), 500)
		return
	}

	w.WriteHeader(200)
	w.Write([]byte("OK"))
}

func handleDown(w http.ResponseWriter, r *http.Request) {
	body, _ := io.ReadAll(r.Body)

	var req UpRequest
	if err := json.Unmarshal(body, &req); err != nil {
		http.Error(w, "invalid JSON", 400)
		return
	}

	if req.Yaml == "" {
		http.Error(w, "missing yaml field", 400)
		return
	}

	if err := compose.Down(req.Yaml); err != nil {
		http.Error(w, err.Error(), 500)
		return
	}

	w.WriteHeader(200)
	w.Write([]byte("OK"))
}
