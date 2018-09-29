<?php

namespace AppBundle\Model;

class Task { 

	private $_content;
	private $_user;
	private $_title;
	private $_id;
	private $_priority;

	function __construct($Nid, $Ncontent, $Nuser, $nTitle, $Nprio) {
		$this->_id = $Nid;
		$this->_content = $Ncontent;
		$this->_user = $Nuser;
		$this->_title = $nTitle;
		$this->_priority = $Nprio;
	}

	public function getContent() {
		return $this->_content;
	}

	public function getUser() {
		return $this->_user;
	}

	public function getId() {
		return $this->_id;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function getPriority() {
		return $this->_priority;
	}

	public function setTitle($nTitle) {
		return $this->_title = $nTitle;
	}

	public function setContent($Ncontent) {
		return $this->_content = $Ncontent;
	}

	public function setUser($Nuser) {
		return $this->_user = $Nuser;
	}

	public function setId($Nid) {
		return $this->_id = $Nid;
	}

	public function setPriority($Nprio) {
		return $this->_priority = $Nprio;
	}

}