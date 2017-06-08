<?php
require_once ("User.php");

define ('USER_FILE', 'users.json');

function initAllUsers () {
	global $allUsers;

	$obj = readJSON (USER_FILE);
	$allUsers = new Users($obj);
}

function getAllUsers () {
	global $allUsers;

	if (is_null($allUsers))
		initAllUsers();

	return $allUsers;
}

function saveUsers () {
	$allUsers = getAllUsers();
	$obj = new stdClass();
	$obj->chatIds = $allUsers->chatIds;
	$obj->size = $allUsers->size;
	writeJSONToFile (USER_FILE, $obj);
}

?>