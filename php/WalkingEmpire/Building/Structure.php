<?php

namespace WalkingEmpire\Building;


include_once 'Resource.php';
include_once 'War.php';

include_once '../datatbase/sqlutils.php';

abstract class Structure {
	// Type parameters:
	// 0: command
	// 1: 
	private $structureId;
	private $type;
	private $baseId;
	private $row;
	private $column;
	private $integrity;
	private $createTime;
	private $creator;
	
	private $resource;
	private $war;
	
	private $sql;
	
	static function newStructure($type, $baseId, $row, $column, $creator) {
		$obj = new Structure(null, $type, $baseId, $row, $column, 100, time(), $creator);
		
		$result = $this->create();
		if ($result === false)
			return false;
		
		return $obj;
	}
	
	static function getStructure($structureId) {
		$result = $this->sql->getRow("structures", "structureid", $structureId);
		if ($result === false)
			return false;
		
		$obj = new Structure($result['structureid'], $result['base'], $result['row'], 
				$result['col'], $result['integrity'], $result['createtime'], $result['creator']);
		
		return $obj;
	}
	
	function __construct($structureId, $type, $baseId, $row, $column, $integrity, $createTime, $creator) {
		$this->structureId = $structureId;
		$this->type = $type;
		$this->baseId = $baseId;
		$this->row = $row;
		$this->column = $column;
		$this->integrity = $integrity;
		$this->createTime = $createTime;
		$this->creator = $creator;
		
		$this->sql = new SQLUtils();
		
		$resource = new Resource();
		$war = new War();
	}
	
	function create() {
		// Get new structureid
		$structureId = $this->generateId();
		if ($structureId === false)
			return false;
		$this->structureId = $structureId;
		
		$columnStr = "`structureid`, `base`, `type`, `name`, `row`, `col`, 
				`integrity`, `createtime`, `creator`";
		$valueStr = sprintf("'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'", 
				$structureId, $this->baseId, $this->type, $this->name,
				$this->row, $this->col, $this->integrity, time(), $this->creator);
		
		$result = $this->sql->insert("structures", $columnStr, $valueStr);
		if ($result === false)
			return false;
		
		return true;
	}
	
	function setIntegrity($integrity) {
		$equivalenceStr = sprintf("`integrity` = '%s'", $integrity);
		$result = $this->sql->update("structures", $equivalenceStr, "structureid", $this->structureId);
		if ($result === false)
			return false;
		
		$this->integrity = $integrity;
		return true;
	}
	
	function destroy() {
		$result = $this->sql->delete("structures", "structureid", $this->structureId);
		if ($result === false)
			return false;
		
		return true;
	}
	
	function generateId() {
		$customQueryInput = "SELECT `structureid` FROM `structures` ORDER BY `structureid` DESC";
		$result = $this->sql->customQuery($customQueryInput);
		if ($result === false)
			return false;
		$structureId = $row['userid'] + 1;
		return $structureId;
	}
	
	function getStatus() {
		$array = array('structureId' => $this->structureId,
						'base' => $this->baseId,
						'integrity' => $this->integrity,
						'row' => $this->row,
						'column' => $this->column,
						'creator' => $this->creator);
		
		return $array;
	}
}

?>
