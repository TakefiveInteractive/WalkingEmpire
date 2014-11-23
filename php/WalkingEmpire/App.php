<?php

namespace WalkingEmpire;

/**
 * Global methods and fields
 */
class App {

    private static $input_data;
    private static $userID;
    private static $accessToken;

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

    /**
     * Set the internal fields (Facebook User ID, Facebook Access Token) once the
     * user is successfully authenticated (Be it with token or with cookie).
     */
    public static function setLoggedIn($id, $token) {
        self::$userID = $id;
        self::$accessToken = $token;
    }
}
