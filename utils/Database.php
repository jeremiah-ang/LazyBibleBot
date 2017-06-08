<?php 

class Database {
	var $HOST = "localhost";
	var $USERNAME = "jjeremia_bot";
	var $PASSWORD = "-Jeremi@h94";
	var $DATABASE = "jjeremia_jermsbot";

	var $connection = null;

	function connect () {
		$this->connection = mysqli_connect($this->HOST, $this->USERNAME, $this->PASSWORD, $this->DATABASE);
	}
	function disconnect () {
		mysqli_close($this->connection);
		$this->connection = null;
	}
	function getConnection () {
		if (is_null($this->connection)) {
			$this->connect();
			return $this->getConnection();
		} else return $this->connection;
	}

	function query ($query) {
		$result = mysqli_query ($this->getConnection(), $query);
		$this->disconnect();
		return $result;
	}

}
?>