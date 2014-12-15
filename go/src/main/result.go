package main

import "encoding/json"

type Result struct {
	success bool
	comment string `json:",omitempty"`
	time    int16  `json:",omitempty"`
}

func GetResult(isSuccess bool) *Result {
	result := &Result{success: isSuccess}
	return result
}

func GetSuccess(comment string) *Result {
	result := &Result{true, comment}
	return result
}

func GetFailure(comment string) *Result {
	result := &Result{false, comment}
	return result
}

func (r *Result) ToJson() string {
	jsonStr, err = json.Marshal(r)
	return jsonStr, err
}
