<?php
namespace WalkingEmpire;

class LocationResponse {

	var $success = true;

	var $buildings_removed = array();

	var $buildings_changed = array();

	var $buildings_added = array();

	function __construct(){
		$this->buildings_added['yyyy-1'] = array(
			'type' => 'base'
		);
	}
}

