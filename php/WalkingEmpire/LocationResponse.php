<?php
namespace WalkingEmpire;

class LocationResponse {

	var $success = true;

	var $buildingsRemoved = array();

	var $buildingsChanged = array();

	var $buildingsAdded = array();
	
	function getResponse($isSuccess, array $bldgRemoved, array $bldgChanged, array $bldgAdded) {
		$this->buildingsAdded = $bldgAdded;
		$this->buildingsChanged = $bldgChanged;
		$this->buildingsRemoved = $bldgRemoved;

		$array = array('');
	}
}
?>
