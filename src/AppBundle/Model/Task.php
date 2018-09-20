<?php

namespace AppBundle\Model;

class Task { 

	private $content;
	private $user;
	
	function __construct($Ncontent, $Nuser) {
		$this->content = $Ncontent;
		$this->user = $Nuser;
	}

	public function getContent() {
		return $this->content;
	}

	public function getUser() {
		return $this->user;
	}

	public function setContent($Ncontent) {
		return $this->content = $Ncontent;
	}
}