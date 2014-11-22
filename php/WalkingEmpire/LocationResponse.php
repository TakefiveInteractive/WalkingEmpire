<?php
namespace WalkingEmpire;

class LocationResponse {

	var $success = true;

	var $buildingsRemoved = array();

	var $buildingsChanged = array();

	var $buildingsAdded = array();
	
	// A static function returning a json string
	function getResponse($isSuccess, array $bldgRemoved, array $bldgChanged, array $bldgAdded) {
		$this->success = $isSuccess;
		$this->buildingsAdded = $bldgAdded;
		$this->buildingsChanged = $bldgChanged;
		$this->buildingsRemoved = $bldgRemoved;
	
		// Generate array
		$array = array('success' => $this->success, 
						'buildings_removed' => $this->buildingsRemoved, 
						'buildings_changed' => $this->buildingsChanged, 
						'buildings_added' => $this->buildingsAdded);
		
		return json_encode($array);
	}
}
?>
