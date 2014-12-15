package main

import (
	"net/http"
	"time"
)

type Server struct {
	Name         string
	Status       int
	PlayerBuffer *[]Player
	StartTime    uint16
}

func InitServerWithName(name string) *Server {
	serv := InitServer()
	serv.Name = name
}

func InitServer() (*Server, error) {
	serv := &Server{nil, 0, nil, time.UnixDate}

	// Handles requests
	http.HandleFunc("/login", login)             //Login
	http.HandleFunc("/checkcookie", checkCookie) // Check for cookie

	// Listen to requests
	err := http.ListenAndServe(":32507", nil)
	if err != null {
		return nil, err
	}

	go clearBuffer()

	return serv, nil
}

func clearBuffer() {}

func login(w http.ResponseWriter, r *http.Request) {}

func checkCookie(w http.ResponseWriter, r *http.Request) {}

func SendResponse(w http.ResponseWriter, r *http.Request) {}
