<?php

namespace WalkingEmpire;

using \WalkingEmpire\Login\Result;

class AddBaseResponse extends Result {
    public $baseID;

    public function __construct($success, $baseID) {
        parent::__construct($success);
        $this->baseID = $baseID;
    }
}

class BaseManager {

    public function __construct() {
    }

    /**
     * Return all bases in the area, either in checkpoint format or wholesale.
     */
    public function queryAllBases() {
    }

    public function addBase() {
        $input = App::getInput();

        if (!property_exists($input, "latitude") || !property_exists($input, "longitude"))
            return new Result(false, "No location information.");

        $ret = Base::newBase($input->longitude, $input->latitude, App::getUserID());
        if ($ret === FALSE)
            return new Result(false, "Creating base failed.");

        return new AddBaseResponse(true, $ret->baseId);
    }

    public function getBase() {
    }

    public function foughtBase() {
    }

    public function buildStructure() {
    }

    private function updateBase() {
    }
}
