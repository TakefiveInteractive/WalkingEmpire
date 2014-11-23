<?php

namespace WalkingEmpire\Login;

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

    /**
     * Merge two Result classes. If one of them is unsucessful, the resulting Result will be unsucessful.
     */
    public static function mergeResults($obj1, $obj2) {
        $obj_merged = (object) array_merge((array) $obj1, (array) $obj2);
        // if one result fails, result fails.
        if (!$obj1->success || !$obj2->success)
            $obj_merged->success = FALSE;
        return $obj_merged;
    }

}

