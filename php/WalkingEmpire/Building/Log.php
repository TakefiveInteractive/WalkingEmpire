<?php
namespace WalkingEmpire\Building;
use WalkingEmpire\database\SQLUtils;

class Log {
	private $logId;
	private $isAdd;
	private $structure;
	private $time;
	
	private $sql;
	
	static function newLog($isAdd, $structure) {
		$obj = new Log(null, $isAdd, $structure, time());
		$result = $obj->create();
		if ($result === false)
			return false;
		
		return true;
	}
	
	static function getlog($startAt, $endAt) {
		$queryStr = sprintf("SELECT * FROM `logs` WHERE `time` > '%s' AND `time` < '%s'", 
				$startAt, $endAt);
		$sql = new SQLUtils();
		$result = $sql->customQuery($queryStr);
		if ($result === false)
			return false;
		
		$array = array();
		foreach ($result as $row) {
			$obj = new Log($row['logid'], $row['isAdd'], $row['structure'], $row['time']);
			$array[] = $obj;
		}
		
		return $array;
	}
	
	function __construct($logId, $isAdd, $structure, $time) {
		$this->logid = $logId;
		$this->isAdd = $isAdd;
		$this->structure = $structure;
		$this->time = $time;
		
		$this->sql = new SQLUtils();
	}
	
	function create() {
		// Get new logid
		$logId = $this->generateId();
		if ($logId === false)
			return false;
		$this->logId = $logId;
		
		$columnStr = "`logid`, `isadd`, `structure`, `time`";
		$valueStr = sprintf("'%s', '%s', '%s', '%s'", 
				$this->logId, $this->isAdd, $this->structure, $this->time);
		$result = $this->sql->insert("logs", $columnStr, $valueStr);
		if ($result === false)
			return false;
		
		return true;
	}
	
	function getStatus() {
		$array = array('logid' => $this->logId,
						'isAdd' => $this->isAdd,
						'structure' => $this->structure,
						'time' => $this->time);
		
		return $array;
	}
	
	function generateId() {
		$customQueryInput = "SELECT `logid` FROM `logs` ORDER BY `logid` DESC";
		$result = $this->sql->customQuery($customQueryInput);
		if ($result === false)
			return false;
		$logId = $row['logid'] + 1;
		return $logId;
	}
}

?>