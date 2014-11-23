<?php

namespace WalkingEmpire;

use \WalkingEmpire\Login\Result;

class AddBaseResponse extends Result {
    public $baseID;

    public function __construct($success, $baseID) {
        parent::__construct($success);
        $this->baseID = $baseID;
    }
}

class GetBaseResponse extends Result {

}

class BaseManager {

    private $input;

    public function __construct() {
        $this->input = App::getInput();
    }

    /**
     * Return all bases in the area, either in checkpoint format or wholesale.
     */
    public function queryAllBases() {
        if (!property_exists($this->input, "last_updated"))
            return new Result(false, "No last_updated");
        //
    }

    public function addBase() {
        // check if input data structure is legal
        if (!Util\Coord::hasLatLon($this->input))
            return new Result(false, "No location information.");

        $ret = Base::newBase($this->input->longitude, $this->input->latitude, App::getUserID());
        if ($ret === FALSE)
            return new Result(false, "Creating base failed.");

        return new AddBaseResponse(true, $ret->baseId);
    }

    public function getBase() {
        if (!property_exists($this->input, "baseID"))
            return new Result(false, "baseID needed");

        $baseID = $this->input->baseID;
        $base = Base::getBase($baseID);
        if (!isset($base))
            return new Result(false, "non-existent base");

        // get all the structures in a base
        $structures = $base->getStructure();

    }

    public function foughtBase() {
    }

    public function buildStructure() {
    }

    private function updateBase() {
        // 
    }
}
