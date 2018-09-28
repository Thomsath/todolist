<?php

namespace AppBundle\Model;

class User { 
	
	private $id;
	private $name;
	

	function __construct($nID, $nName) {
		$this->id = $nID;
		$this->name = $nName;
		
	}

	public function getName() {
		return $this->name;
	}

	public function getID() {
		return $this->id;
	}

	public function setName($Nname) {
		return $this->name = $Nname;
	}
}