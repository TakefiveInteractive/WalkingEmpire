<?php

namespace WalkingEmpire;

use WalkingEmpire\database\SQLUtils;
use WalkingEmpire\Building\Structure;


class Base {
	private $baseId;
	private $longitude;
	private $latitude;
	private $createTime;
	private $owner;
	
	private $structure;
	
	private $sql;
	
	static function newBase($longitude, $latitude, $owner) {
		$obj = new Base(null, $longitude, $latitude, $owner);
	
		$result = $this->create();
		if ($result === false)
			return false;
	
		return $obj;
	}
	
	static function getBase($baseId) {
		$result = $this->sql->getRow("bases", "baseid", $baseId);
		if ($result === false)
			return false;
	
		$obj = new Base($result['baseid'], $result['longitude'], 
				$result['latitude'], $result['owner']);
	
		return $obj;
	}
	
	function __construct($baseId, $longitude, $latitude, $creator) {
		$this->baseId = $baseId;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->creator = $creator;
		
		$this->sql = new SQLUtils();
	}
	
	function create() {
		// Get new baseid
		$baseId = $this->generateId();
		if ($baseId=== false)
			return false;
		$this->baseId = $baseId;
	
		$columnStr = "`baseid`, `longitude`, `latitude`, `owner`";
		$valueStr = sprintf("'%s', '%s', '%s', '%s'", $baseId, $this->longitude, $this->latitude, $this->owner);
		$result = $this->sql->insert("structures", $columnStr, $valueStr);
		if ($result === false)
			return false;
	
		return true;
	}
	
	function getStructure() {
		$result = $this->sql->select("*", "structures", "base", $this->baseId);
		if ($result === false)
			return false;
		
		$array = array();
		foreach ($result as $tempRow)
			$array[] = $tempRow['structure'];
		
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
		$baseId = $row['baseid'] + 1;
		return $baseId;
	}
}

?>
