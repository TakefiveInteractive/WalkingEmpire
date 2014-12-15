package models

import "encoding/json"

type Result struct {
	success bool
	comment string
	time    int64
}

func (r *Result) ToJson() string {
	jsonStr, err = json.Marshal(r)
	return jsonStr, err
}
