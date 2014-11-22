<?php

class Game {
	private 
	private $belligerent1;
	private $belligerent2;
	private $createTime;
	
	static function getNewInstance() {
		
	}
	
	function __construct($belligerent1, $belligerent2) {
		$this->belligerent1 = $belligerent1;
		$this->belligerent2 = $belligerent2;
		$this->createTime = time();
	}
	
	function addToDatabase() {
		
	}
}

?>