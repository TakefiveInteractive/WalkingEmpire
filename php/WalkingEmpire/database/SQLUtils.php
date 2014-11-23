<?php

namespace WalkingEmpire\database;

class SQLUtils {
	
	private $conn;
	
	function SQLUtils() {
		$this->conn = mysqli_connect("54.201.2.40", "walkingempire", "h22HT2cWPsb8QaMx");
		mysqli_select_db("billboard", $this->conn);
	}
	
	function select($column, $table, $parameter, $value) {
		$queryStr = sprintf("SELECT %s FROM `%s` WHERE `%s` = '%s'", $column, $table, $parameter, $value);
		$result = mysqli_query($queryStr, $this->conn);
		if (mysqli_errno($this->conn) == 0) {
			if (mysqli_num_rows($result) > 1) {
				$array = array();
				while ($row = mysqli_fetch_array($result))
					$array[] = $row;
				return $array;
			}
			else
				return mysqli_fetch_array($result);
		}
		else
			return false;
	}
	
	function insert($table, $columnStr, $valueStr) {
		$queryStr = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $table, $columnStr, $valueStr);
		$result = mysqli_query($queryStr, $this->conn);
		if (mysqli_errno($this->conn) == 0)
			return true;
		else
			return false;
	}
	
	function update($table, $equivalenceStr, $parameter, $value) {
		$queryStr = sprintf("UPDATE `%s` SET (%s) WHERE `%s` = '%s'", $table, $equivalenceStr, $parameter, $value);
		$result = mysqli_query($queryStr, $this->conn);
		return $result;
	}
	
	function delete($table, $parameter, $value) {
		$queryStr = sprintf("DELETE FROM `%s` WHERE `%s` = '%s'", $table, $parameter, $value);
		$result = mysqli_query($queryStr, $this->conn);
		return $result;
	}
	
	function getRow($table, $parameter, $value) {
		$result = $this->select("*", $table, $parameter, $value);
		if ($result === false)
			return false;
		
		return $result;
	}
	
	function checkAvailability($table, $parameter, $value) {
		$queryStr = sprintf("SELECT '%s' FROM `%s` WHERE `%s` = '%s'", "*", $table, $parameter, $value);
		$result = mysqli_query($queryStr, $this->conn);
		if (mysqli_num_rows($result) == 0)
			return true;
		else
			return false;
	}
	
	function customQuery($queryStr) {
		return mysqli_query($queryStr, $this->conn);
	}
	
	function generateId() {
		$customQueryInput = "SELECT `userid` FROM `bbUsers` ORDER BY `userid` DESC";
		$result = $this->customQuery($customQueryInput);
		$row = mysqli_fetch_array($result);
		$userId = $row['userid'] + 1;
		return $userId;
	}
	
	function getConnection() {
		return $this->conn;
	}
	
	function destroy() {
		mysqli_close($this->conn);
	}
	
}

?>
