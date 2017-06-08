<?php
require_once ('utils/bible.php');
require_once ('utils/fileSystem.php');
require_once ('utils/http.php');
require_once ('utils/telegram.php');
require_once ('utils/User.php');
require_once ('utils/usersController.php');

function process_text ($text, $from) {
	if ($text == "/start") {
		$username = ($from['username']) ? $from['username'] : $from['first_name'];
		$id = $from['id'];
		if (!getAllUsers()->exists($id)) {
			getAllUsers()->add($id, $username);
			saveUsers ();
			sendMessage ($id, "Subscribed!");
		}
	}
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);
$text = $update['message']['text'];

process_text ($text, $update['message']['from']);
//sendMessage ($chatId, $text);


?>

