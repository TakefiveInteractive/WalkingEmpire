<?php

namespace WalkingEmpire/Login;

/**
 * JSON class representing login result
 */
class Result {

    public $success;

    public $comment;

    function __construct($success, $comment = "None") {
        $this->success = $success;
        $this->comment = $comment;
    }
}

