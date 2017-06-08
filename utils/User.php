<?php
/* ============================
	
		User Object

============================ */

class Users {
	var $chatIds;
	var $size;

	function __construct ($json) {
		$this->chatIds = $json->chatIds;
		$this->size = $json->size;
	}

	function getChatIds () {
		return $this->chatIds;
	}

	function add ($chatId, $username) {
		$this->chatIds->$chatId = $username;
		$this->size++;
	}

	function delete ($chatId) {
		unset ($this->chatIds->$chatId);
		$this->size--;
	}

	function exists ($chatId) {
		return !is_null($this->chatIds->$chatId);
	}
}

?>