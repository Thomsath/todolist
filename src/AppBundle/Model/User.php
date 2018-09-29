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

	public function getId() {
		return $this->id;
	}

	public function setId($Nid) {
		return $this->id = $Nid;
	}

	public function setName($Nname) {
		return $this->name = $Nname;
	}
}