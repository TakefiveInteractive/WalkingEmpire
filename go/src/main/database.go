package main

import (
	"database/sql"
	"fmt"
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
	address := fmt.Sprintf("%s:%s@/%s", DbUsername, DbPassword, DbAddress)
	db, err := sql.Open(dbname, address)
	return db, err
}

func DoSelect(r *Request) {

	if r == nil {
		return nil, GetFailure("Empty channel")
	}

	db, err := initDatabaseConnection(dbname)
	if err != nil {
		return nil, GetFailure("Cannot connect to database")
	}

	selectStatement, err := db.Prepare("SELECT ? FROM ? WHERE ? = ?")
	if err != nil {
		return nil, GetFailure("Cannot prepare statement")
	}
	defer selectStatement.Close()

	var values []string
	for _, v := range r.columns {
		result, err = selectStatement.Exec(v)
	}

}

func DoInsert() {

}
