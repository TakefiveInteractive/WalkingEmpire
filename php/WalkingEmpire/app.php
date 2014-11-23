<?php

namespace WalkingEmpire;

/**
 * Global methods and fields
 */
class App {

    private static $input_data;
    private static $userID;
    private static $accessToken;
    private static $cookie;

    public static function setInput($input) {
        self::$input_data = $input;
    }

    public static function getInput() {
        return self::$input_data;
    }

    public static function getUserID() {
        return self::$userID;
    }

    public static function getAccessToken() {
        return self::$accessToken;
    }

    public static function getCookie() {
        return self::$cookie;
    }

    /**
     * Set the internal fields (Facebook User ID, Facebook Access Token, Cookie) once the
     * user is successfully authenticated (Be it with token or with cookie).
     */
    public static function setLoggedIn($id, $token, $coo) {
        self::$userID = $id;
        self::$accessToken = $token;
        self::$cookie = $coo;
    }
}
