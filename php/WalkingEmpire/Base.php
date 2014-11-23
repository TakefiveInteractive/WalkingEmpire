<?php

namespace WalkingEmpire;

use WalkingEmpire\database\SQLUtils;
use WalkingEmpire\Building\Structure;

class Base {
	public $baseId;
	private $longitude;
	private $latitude;
	private $createTime;
	private $owner;
	
	private $structure;
	
	private $sql;
	
	static function newBase($longitude, $latitude, $owner) {
		$obj = new Base(null, $longitude, $latitude, $owner);
	
		$result = $obj->create();
		if ($result === false)
			return false;
	
		return $obj;
	}
	
	static function getBase($baseId) {
        $sql = new SQLUtils();
		$result = $sql->getRow("bases", "baseid", $baseId);
		if ($result === false)
			return false;
	
		$obj = new Base($result['baseid'], $result['longitude'], 
				$result['latitude'], $result['owner']);
	
		return $obj;
	}

    public static function getAllBases() {
		$sql = new SQLUtils();
		$queryStr = "SELECT * FROM `bases`";
		$result = $sql->customQuery($queryStr);
		if ($result === false)
			return false;
		
		$array = array();
		foreach ($result as $x) {
			$obj = new Base($x['baseid'], $x['longitude'], $x['latitude'], $x['owner']);
			$array[] = $obj;
		}
		
		return $array;
	}

	function __construct($baseId, $longitude, $latitude, $owner) {
		$this->baseId = $baseId;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->owner = $owner;
		
		$this->sql = new SQLUtils();
	}
	
	function create() {
		// Get new baseid
		$baseId = $this->generateId();
		if ($baseId === false)
			return false;
		$this->baseId = $baseId;
		$columnStr = "`baseid`, `longitude`, `latitude`, `owner`";
		$valueStr = sprintf("'%s', '%s', '%s', '%s'", $baseId, $this->longitude, $this->latitude, $this->owner);
		$result = $this->sql->insert("bases", $columnStr, $valueStr);
		if ($result === false)
			return false;
	
		return true;
	}
	
	function addStructure($type, $row, $column) {
		$result = Structure::newStructure($type, $this->baseId, $row, $column, $this->owner);
		if ($result === false)
			return false;
		
		return true;
	}
	
	function deleteStructure($structureId) {
		$result = $this->sql->delete("structures", "structureid", $structureId);
		if ($result === false)
			return false;
		
		return true;
	}
	
	function getStructure() {
		$result = $this->sql->select("*", "structures", "base", $this->baseId);
		if ($result === false)
			return false;
		
		$array = array();
        if (count($result) !== 0) {
            if (!is_array(array_values($result)[0])) {
                $array = $result;
            } else {
                foreach ($result as $tempRow)
                    $array[] = $tempRow['structure'];
            }
        }
		
		$structureArr = array();
		foreach ($array as $structureId) {
			$structure = Structure::getStructure($structureId);
			$structureArr[] = $structure;
		}
		
		return $structureArr;
	}
	
	function changeOwner($owner) {
		$equivalenceStr = sprintf("`owner` = '%s'", $owner);
		$result = $this->sql->update("bases", $equivalenceStr, "baseid", $this->baseId);
		if ($result === false)
			return false;
		
		$this->owner = $owner;
		return true;
	}
	
	function getStatus() {
		$array = array('baseId' => $this->baseId,
				'longitude' => $this->longitude,
				'latitude' => $this->latitude,
				'owner' => $this->owner);
	
		return $array;
	}
	
	function destroy() {
		$result = $this->sql->delete("bases", "baseId", $this->baseId);
		if ($result === false)
			return false;
		
		return true;
	}
	
	function generateId() {
		$customQueryInput = "SELECT `baseid` FROM `bases` ORDER BY `baseid` DESC";
		$result = $this->sql->customQuery($customQueryInput);
		if ($result === false)
			return false;
		$baseId = $result['baseid'] + 1;
		return $baseId;
	}
}

?>
