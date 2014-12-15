package main

import (
	"flag"
	"fmt"
)

var thisServer *Server
var serverName, serverOperation string
var isServerRunning bool

func init() {
	// Get flags
	serverOperation = flag.String("operation", nil, "server operation")
	serverName = flag.String("name", nil, "server name")
	flag.Parse()
}

func main() {
	// Test for flags
	if serverOperation == nil || serverName == nil {
		return
	}

	switch serverOperation {
	case "start":
		if isServerRunning {
			fmt.Println("Already running")
			break
		}
		err error
		thisServer, err = InitServerWithName(serverName)
		if err != nil {
			fmt.Println("Error occured")
		}
		isServerRunning = true
		fmt.Println("Started successfully")
	case "stop":
		thisServer = nil
		isServerRunning = false
		fmt.Println("Stopped successfully")

}
