package db

import (
	"main"
	"fmt"
	"database/sql"
	"models/result"
	_ "github.com/go-sql-driver/mysql"
)

type Request struct {
	action    string
	tableName string
	columns   []string
	values    []string
}

var DEFAULT_TABLE string = "walkingempire"

func initDatabaseConnection(dbname string) (*sql.DB, error) {
	if dbname == nil {
		dbname = DEFAULT_TABLE
	}
	address := fmt.Sprintf("%s:%s@/%s", )
	db, err := sql.Open(dbname, "user:password@/database")
	return db, err
}

func DoSelect(c chan *Request) {
	err error

	request := <-c
	if request == nil {
		return nil, err
	}

	gb, err := initDatabaseConnection(dbname)
	if err != nil {
		return nil, err
	}
}

func DoInsert() {

}
