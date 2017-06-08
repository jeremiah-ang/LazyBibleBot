<?php
/* ============================
	
		User Object

============================ */

class User {
	var $chatIds;
	var $username;
	var $hour;

	function __construct ($chatIds, $username, $hour) {
		$this->chatIds = $chatIds;
		$this->username = $username;
		$this->setHour ($hour);
	}

	function getChatId () {
		return $this->chatIds;
	}
	function getUsername () {
		return $this->username;
	}
	function getHour () {
		return (is_null($this->hour)) ? "08:00:00" : $this->hour;
	}
	function setHour ($hour) {
		if (is_null($hour) || $hour < 0) 
			$this->hour = "08:00:00";
		else {
			$hour = ($hour < 10) ? "0" . $hour : $hour;
			$this->hour = $hour . ":00:00";
		}
	}
}

?>