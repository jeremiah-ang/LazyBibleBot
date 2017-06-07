<?php

/* ============================
	
			GLOBALS

============================ */

define ('BOT_TOKEN', '386938857:AAHnHyE1XOfw31wELyKhvtDvyvUeSbUIuV4');
define ('USER_FILE', 'users.json');
define ('SSH', 'iK~.7?$)[9&u');

$allUsers;
$toDelete = [];
$completed = 0; 

/* ============================
	
		HTTP/HTTPS API

============================ */

function getRequest ($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($curl);
	return $response;
}

/* ============================
	
		FILE SYSTEM API

============================ */

function readJSON ($file) {
	return json_decode(file_get_contents($file));
}

function writeJSONToFile ($file, $json) {
	$fp = fopen ($file, 'w');
	fwrite($fp, json_encode($json));
	fclose($fp);
}

/* ============================
	
		Telegram API

============================ */

function getUpdate () {
	return json_decode(getRequest ("https://api.telegram.org/bot".BOT_TOKEN."/getUpdates"));
}

function sendMessage ($chatId, $msg) {
	$url = "https://api.telegram.org/bot".BOT_TOKEN."/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg);

	return json_decode(getRequest ($url));
}

/* ============================
	
		   Bible API

============================ */

function sendVerse ($username, $chatId) {
	$votdUrl = "http://labs.bible.org/api/?passage=random";
	$response = getRequest ($votdUrl);

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


function saveUsers () {

	$allUsers = getAllUsers();

	$obj = new stdClass();
	$obj->chatIds = $allUsers->chatIds;
	$obj->size = $allUsers->size;

	writeJSONToFile (USER_FILE, $obj);
}

function deleteBlockedUsers () {
	global $toDelete;

	for ($i = 0; $i < count($toDelete); $i++) {
		getAllUsers()->delete($toDelete[$i]);
	}
}

function process_text ($text, $from) {
	if ($text == "/start") {
		$username = ($from['username']) ? $from['username'] : $from['first_name'];
		$id = $from['id'];
		if (!getAllUsers()->exists($id)) {
			getAllUsers()->add($id);
			saveUsers ();
			sendMessage ($id, "Subscribed!");
		}
	}
}


$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chatId = $update['message']['from']['id'];
$text = $update['message']['text'];

process_text ($text, $update['message']['from']);
sendMessage ($chatId, $text);


?>

