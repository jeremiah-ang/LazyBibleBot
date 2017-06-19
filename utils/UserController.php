<?php
require_once ("User.php");
require_once ("Database.php");
require_once ("fileSystem.php");

class UserController {

	var $table = "`Users`";
	var $update = false;
	var $allUsers;
	var $db;

	function __construct () {
		$this->db = new Database();
	}

	function updated () {
		$this->update = true;
	}

	function getAllUsers () {
		if ($this->updated || is_null($this->allUsers)) {
			$this->allUsers = $this->retrieve_all();
			$this->updated = false;
		} 

		return $this->allUsers;
	}

	function resultsToUsers ($results) {
		$users = [];
		while ($result = mysqli_fetch_assoc ($results)) {
			$users[] = new User($result['chatId'], $result['username'], $result['hour'], $result['command']);
		}
		return $users;
	}
	function retrieve_all () {
		$query = "SELECT * FROM ".$this->table;
		$results = $this->exec ($query);
		return $this->resultsToUsers($results);
	}
	function retrieve_id ($id) {
		$query = "SELECT * FROM ".$this->table." WHERE `chatId` = " . $id;
		return $this->resultsToUsers($this->exec ($query))[0];
	}
	function retrieve_hour ($hour) {
		$query = "SELECT * FROM ".$this->table." WHERE `hour` = " . $this->quote($hour);
		return $this->resultsToUsers($this->exec ($query));
	}
	function create ($user) {
		$query = "INSERT INTO `Users` (`chatId`, `username`, `hour`) VALUES (" . $this->quote($user->getChatId()) . ", " . $this->quote($user->getUsername()) . ", " . $this->quote($user->getHour()) . ")";
		return $this->exec ($query);
	}
	function create_multiple ($users) {
		foreach ($users as $user) {
			$this->create($user);
		}
	}

	function update ($user) {
		$query = "UPDATE `Users` SET `username` = " . $this->quote($user->getUsername()) . ", `hour` = " . $this->quote($user->getHour()) . ",`command` = " . $this->quote($user->getCommand()) . " WHERE `Users`.`chatId` = " . $user->getChatId();
		$this->updated();
		return $this->exec ($query);
	}

	function delete ($user) {
		$query = "DELETE FROM `Users` WHERE `Users`.`chatId` = " . $user->getChatId();
		return $this->exec ($query);
	}

	function exists ($user) {
		return count($this->retrieve_id($user->getChatId())) > 0;
	}

	function exec ($query) {
		return $this->db->query($query);
	}

	function quote ($str) {
		return '"' . $str . '"';
	}
}

?>