<?php
/* ============================
	
		User Object

============================ */

class User {
	var $chatIds;
	var $username;
	var $hour;
	var $command;
	var $cache;

	function __construct ($chatIds, $username, $hour, $command, $cache) {
		$this->chatIds = $chatIds;
		$this->username = $username;
		$this->setHour ($hour);
		$this->command = $command;
		$this->cache = $cache;
	}

	function shouldReceive ($hour) {
		$hourArray = explode (",", $this->hour);
		foreach ($hourArray as $h) {
			if (intval($h) == intval($hour)) {
				return true;
			}
		}
		return false;
	}

	function getChatId () {
		return $this->chatIds;
	}
	function getUsername () {
		return $this->username;
	}
	function getHour () {
		return (is_null($this->hour)) ? "8,12,16,23" : $this->hour;
	}
	function setHour ($hour) {
		if (is_null($hour) || $hour < 0) 
			$this->hour = "8,12,16,23";
		else {
			$this->hour = $hour;
		}
	}
	function getCommand () { return $this->command; }
	function setCommand ($command) { $this->command = $command; }

	public static $SET_HOUR_COMMAND = 201;
	public static function IS_SET_HOUR_COMMAND ($command) {
		return intval(trim($command)) == User::$SET_HOUR_COMMAND;
	}
	public static $SET_BOOK_COMMAND = 202;
	public static function IS_SET_BOOK_COMMAND ($command) {
		return intval(trim($command)) == User::$SET_BOOK_COMMAND;
	}
	public static $SET_VERSE_COMMAND = 203;
	public static function IS_SET_VERSE_COMMAND ($command) {
		return intval(trim($command)) == User::$SET_VERSE_COMMAND;
	}
}


?>