<?php
require_once ('../utils/bible.php');
require_once ('../utils/fileSystem.php');
require_once ('../utils/http.php');
require_once ('../utils/telegram.php');
require_once ('../utils/UserController.php');

/* ============================
	
			GLOBALS

============================ */

define ('SSH', 'iK~.7?$)[9&u');

$allUsers;
$toDelete = [];
$completed = 0; 


/* ============================
	
		Proccesors

============================ */

function sendVerseToAll ($hour) {

	$userController = new UserController ();
	$verse = processVerse(getVerse("random"));
	
	print_r ($verse);
	foreach ($userController->getAllUsers() as $user) {
		if ($user->shouldReceive($hour)) {
			sendVerse ($user->getUsername(), $user->getChatId(), $verse);
		} 
	}

	deleteBlockedUsers($userController);
}

function deleteBlockedUsers ($userController) {
	global $toDelete;
	for ($i = 0; $i < count($toDelete); $i++) {
		$userController->delete($toDelete[$i]);
	}
}

function processVerse ($verse) {
	return preg_replace('/<[^>]*>/', "", $verse);
}

function sendVerse ($username, $chatId, $verse) {
	global $toDelete;

	$response = sendMessage ($chatId, $verse);

	$completed = $completed + 1;
	if ($response->ok) {
		echo "Sent to: " . $username . "\n";
	} else if ($response->error_code == 403) {
		echo "Failed to Send to: " . $username . "\n";
		$toDelete[] = new User($chatId, $username, NULL, NULL);
	}

	return true;
}


// readJSON("users.json");
sendVerseToAll(date('H'));

?>

