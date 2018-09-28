<?php

namespace AppBundle\Model;

class Task { 

	private $content;
	private $user;
	private $title;

	function __construct($Ncontent, $Nuser, $nTitle) {
		$this->content = $Ncontent;
		$this->user = $Nuser;
		$this->title = $nTitle;
	}

	public function getContent() {
		return $this->content;
	}

	public function getTaskUser() {
		return $this->user;
	}

	public function setContent($Ncontent) {
		return $this->content = $Ncontent;
	}

	public function getUser() {
		return $this->user;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($nTitle) {
		return $this->title = $nTitle;
	}
}