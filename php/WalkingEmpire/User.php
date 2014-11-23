<?php

namespace WalkingEmpire;
use WalkingEmpire\database\SQLUtils;

class User {
	private $sql;
	
	private $userid;
	private $facebookUserId;
	private $cookie;
	
	static function createUser($userId, $facebookUserId, $cookie) {
		$sql = new SQLUtils();
		$columnStr = "`userid`, `facebookid`, `cookie`";
		$valueStr = sprintf("'%s', '%s', '%s'", $userId, $facebookUserId, $cookie);
		$result = $sql->insert("users", $columnStr, $valueStr);
		$sql->destroy();
		if ($result === false)
			return false;
		
		return true;
	}
	
	static function findUserIdByCookie($cookie) {
		$sql = new SQLUtils();
		$result = $sql->select("userid", "users", "cookie", $cookie);
		$sql->destroy();
		if ($result === false)
			return false;
		
		return $result['userid'];
	}
	
    static function findCookieByFacebookId($facebookid) {
		$sql = new SQLUtils();
		$result = $sql->select("cookie", "users", "facebookid", $facebookid);
		if ($result === false)
			return false;
		return $result['cookie'];
	}

    static function findCookieByUserId($userid) {
		$sql = new SQLUtils();
		$result = $sql->select("cookie", "users", "userid", $userid);
		if ($result === false)
			return false;
		return $result['cookie'];
	}

	static function findFacebookIdByCookie($cookie) {
		$sql = new SQLUtils();
		$result = $sql->select("facebookid", "users", "cookie", $cookie);
		$sql->destroy();
		if ($result === false)
			return false;
		
		return $result['facebookid'];
	}
	
	public static function getAllUsers() {
		$sql = new SQLUtils();
		$queryStr = "SELECT * FROM `users`";
		$result = $sql->customQuery($queryStr);
		if ($result === false)
			return false;
		
		$array = array();
        // if only one user is ever returned, the format of $result will be a one-dim array containing fields
        // otherwise, $result is a two-dim array, where each element is an one-dim array containing the fields
        if (!is_array(array_values($result)[0])) return array(new User($result['cookie']));
		foreach ($result as $tempArr) {
			$obj = new User($tempArr['cookie']);
			$array[] = $obj;
		}
		
		return $array;
	}
	
	function __construct($cookie = null) {
		$this->sql = new SQLUtils();
		$this->cookie = $cookie;
	}
	
	function getUsername() {
		// Get username from cookie
		$usernameResult = User::findUserIdByCookie($this->cookie);
		if ($usernameResult === false)
            return false;

	    $this->userid = $usernameResult;
		return $this->userid;
	}
	
	function setLocation($longitude, $latitude) {
		$equivalenceStr = sprintf("`longitude` = %f, `latitude` = %f", $longitude, $latitude);
		$result = $this->sql->update("users", $equivalenceStr, "cookie", $this->cookie);
		if ($result === false)
			return false;
		else
			return true;
	}
	
    static function setCookieByUserId($cookie, $userId) {
		$equivalenceStr = sprintf("`cookie` = '%s'", $cookie);
		$result = (new SQLUtils())->update("users", $equivalenceStr, "userid", $userId);
		if ($result === false)
			return false;
		else {
			return true;
		}
	}

	function setCookie($cookie) {
		$equivalenceStr = sprintf("`cookie` = '%s'", $cookie);
		$result = $this->sql->update("users", $equivalenceStr, "cookie", $this->cookie);
		if ($result === false)
			return false;
		else {
			$this->cookie = $cookie;
			return true;
		}
	}
	
	function setToken($token) {
		$eqivalenceStr = sprintf("`facebookid` = '%s'", $token);
		$result = $this->sql->update("users", $equivalenceStr, "cookie", $this->cookie);
		if ($result === false)
			return false;
		else
			return true;
	}
	
	function getCookie() {
		return $cookie;
	}
	
	function getToken() {
		$result = $this->sql->select("facebookid", "users", "cookie", $this->cookie);
		if ($result === false)
			return false;
		
		return $result['facebookid'];
	}
	
	function getLocation() {
		$result = $this->sql->select("longitude, latitude", "users", "cookie", $this->cookie);
		if ($result === false)
			return false;	
		else
			return $result;
	}
	
	function getRow() {
		$result = $this->sql->select("*", "users", "cookie", $this->cookie);
		if ($result === false)
			return false;	
		else
			return $result;
	}
}

?>
