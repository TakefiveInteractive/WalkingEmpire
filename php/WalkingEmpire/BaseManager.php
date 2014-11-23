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

class StructureResponse {
    public $id;
    public $hp;
    public $type;
    public $tileX;
    public $tileY;

    public function __construct($structure) {
        $stFields = $structure->getStatus();
        $this->id = $stFields['structureId'];
        $this->hp = $stFields['integrity'];
        // TODO: get type!
        $this->type = "default"; 
        $this->tileX = $stFields['column'];
        $this->tileY = $stFields['row'];
    }
}

class GetBaseResponse extends Result {
    public $structures = array();

    public function __construct($success, $input) {
        parent::__construct($success);
        foreach ($input as $structure)
            $structures[] = new StructureResponse($structure);
    }
}

class BaseResponse {
    public $userid;
    public $latitude;
    public $longitude;

    public function __construct($base) {
        $bFields = $base->getStatus();
        $this->userid = $bFields['owner'];
        $this->latitude = $bFields['latitude'];
        $this->longitude = $bFields['longitude'];
    }
}

class queryAllBasesFullResponse extends Result {
    public $bases = array();

    public function __construct($success, $baseArr) {
        parent::__construct($success);
        foreach ($baseArr as $base) {
            $bFields = $base->getStatus();
            $baseId = $bFields['baseId'];
            $bases[$baseId] = new BaseResponse($base);
        }
    }
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
        // tentatively return everything
        $bases = Base::getAllBases();
        return new queryAllBasesFullResponse(true, $bases);
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
    
    private function verifyBaseIdInput() {
        if (!property_exists($this->input, "baseID"))
            return new Result(false, "baseID needed");

        $baseID = $this->input->baseID;
        $base = Base::getBase($baseID);
        if (!isset($base))
            return new Result(false, "non-existent base");

        return new Result(true);
    }

    public function getBase() {
        $verifyResult = $this->verifyBaseIdInput();
        if (!$verifyResult->success)
            return $verifyResult;
        // get all the structures in a base
        $base = Base::getBase($this->input->baseID);
        $structures = $base->getStructure();
        $ret = new getBaseResponse(true, $structures);
        return $ret;
    }

    public function foughtBase() {
        $verifyResult = $this->verifyBaseIdInput();
        if (!$verifyResult->success)
            return $verifyResult;

        $inputStructures = $this->input->structures;
        $inputKeytoStructures = array();
        // use id of each structure as an index
        foreach ($inputStructures as $x) {
            $inputKeytoStructures[$x->id] = $x;
        }

        $base = Base::getBase($this->input->baseID);
        $structures = $base->getStructure();
        // iterate through array, updating/removing structures as necessary
        foreach ($structures as $key => $structure) {
            $structureStatus = $structure->getStatus();
            $id = $structureStatus['structureId'];
            if (isset($inputKeytoStructures[$id])) {
                // update
                $ret = $structure->setIntegrity($inputKeytoStructures[$id]->hp);    
            } else {
                // destroy
                $ret = $structure->destroy();
            }
            if ($ret === FALSE) return new Result(false, "Cannot modify structure.");
        }
        return new Result(true);
    }

    public function buildStructure() {

    }

    public function takeOverBase() {
    }

    public function destroyBase() {
        $verifyResult = $this->verifyBaseIdInput();
        if (!$verifyResult->success)
            return $verifyResult;

        $base = Base::getBase($this->input->baseID);
        $ret = $base->destroy();
        if ($ret === FALSE)
            return new Result(false, "destroying base failed");

        return new Result(true);
    }

    private function updateBase() {
        // 
    }
}
