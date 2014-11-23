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
        $success1 = $obj1->success;
        $success2 = $obj2->success;

        // remove success from sub results
        $arr1 = (array) $obj1;
        $arr2 = (array) $obj2;
        unset($arr1['success']);
        unset($arr2['success']);
        unset($arr1['comment']);
        unset($arr2['comment']);

        // mergin comment. favor first one.
        if (!empty($obj1->comment))
            $comment = $obj1->comment;
        else
            $comment = $obj2->comment;

        $array_merged = array_merge($arr1, $arr2);
        if (!empty($comment)) $array_merged['comment'] = $comment;

        // if one result fails, final result fails.
        if (!$success1 || !$success2)
            $array_merged['success'] = false;
        else
            $array_merged['success'] = true;

        $obj_merged = (object) $array_merged;
        return $obj_merged;
    }

}

