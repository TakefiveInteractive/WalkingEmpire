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
    public static function mergeResults($obj1, $obj2, $obj1_name, $obj2_name) {
        $success1 = $obj1->success;
        $success2 = $obj2->success;

        // remove success from sub results
        $arr1 = (array) $obj1->$obj1_name;
        $arr2 = (array) $obj2->$obj2_name;
        unset($arr1['success']);
        unset($arr2['success']);
        unset($arr1['comment']);
        unset($arr2['comment']);

        // mergin comment. favor first one.
        if (!empty($obj1->comment))
            $comment = $obj1->comment;
        else
            $comment = $obj2->comment;

        $array_merged = array();
        $array_merged[$obj1_name] = $arr1;
        $array_merged[$obj2_name] = $arr2;
        if (!empty($comment)) $array_merged['comment'] = $comment;

        // if one result fails, final result fails.
        if (!$success1 || !$success2)
            $array_merged['success'] = false;
        else
            $array_merged['success'] = true;

        return $array_merged;
    }

}

