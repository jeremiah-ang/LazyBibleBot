<?php
require_once ('../utils/bible.php');
require_once ('../utils/fileSystem.php');
require_once ('../utils/http.php');
require_once ('../utils/telegram.php');
require_once ('../utils/User.php');
require_once ('../utils/usersController.php');

/* ============================
	
			GLOBALS

============================ */

define ('BOT_TOKEN', '386938857:AAHnHyE1XOfw31wELyKhvtDvyvUeSbUIuV4');
define ('SSH', 'iK~.7?$)[9&u');

$allUsers;
$toDelete = [];
$completed = 0; 


/* ============================
	
		Proccesors

============================ */

function sendVerseToAll () {

	foreach (getAllUsers()->getChatIds() as $chatId => $username) {
		sendVerse ($username, $chatId);
	}

	deleteBlockedUsers();
	saveUsers();
}

function deleteBlockedUsers () {
	global $toDelete;

	for ($i = 0; $i < count($toDelete); $i++) {
		getAllUsers()->delete($toDelete[$i]);
	}
}

function sendVerse ($username, $chatId) {
	$response = getVerse ("random");
	return processVerse ($username, $chatId, $response);
}

function processVerse ($username, $chatId, $verse) {
	global $toDelete;

	$verse = preg_replace('/<[^>]*>/', "", $verse);

	$response = sendMessage ($chatId, $verse);

	$completed = $completed + 1;
	if ($response->ok) {
		echo "Sent to: " . $username . "\n";
	} else if ($response->error_code == 403) {
		echo "Failed to Send to: " . $username . "\n";
		$toDelete[] = $chatId;
	}

	return true;
}



sendVerseToAll();

?>

