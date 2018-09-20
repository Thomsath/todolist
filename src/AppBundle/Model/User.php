<?php

namespace AppBundle\Model;

class User { 

	private $name;

	function __construct($Nname) {
		$this->name = $Nname;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($Nname) {
		return $this->name = $Nname;
	}
}