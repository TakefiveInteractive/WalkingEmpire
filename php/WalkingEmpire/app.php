<?php

namespace WalkingEmpire;

/**
 * Global methods and fields
 */
class App {

    private static $input_data;

    public static function setInput($input) {
        $input_data = $input;
    }

    public static function getInput() {
        return self::$input_data;
    }
}
