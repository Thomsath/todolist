<?php

namespace AppBundle\Model;

class User { 

	private $name;
	private $id;

	function __construct($Nname, $nID) {
		$this->name = $Nname;
		$this->id = $nID;
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