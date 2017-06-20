<?php
require_once ('utils/Bible.php');
require_once ('utils/fileSystem.php');
require_once ('utils/http.php');
require_once ('utils/telegram.php');
require_once ('utils/User.php');
require_once ('utils/UserController.php');
require_once ('utils/getter.php');

require_once ('API/subscribe.php');

require_once ('API/hour/getHour.php');
require_once ('API/hour/setHour.php');
require_once ('API/hour/sendHour.php');

require_once ('API/requestVerse/getVerse.php');
require_once ('API/requestVerse/processRequestedVerse.php');

require_once ('API/getSubscriber.php');

function webhookCalled () {
	$content = file_get_contents("php://input");
	$update = json_decode($content, true);
	$text = $update['message']['text'];

	process_text ($text, $update['message']['chat']);
}

function getUsername ($from) {
	$username = "";
	if ($from['type'] == "group") {
		$username = $from['title'];
	} else {
		$username = ($from['username']) 
				? $from['username'] 
				: $from['first_name'];
	}
	return $username;
}

function getId ($from) {
	return $from['id'];
}

function getCommand ($text) {
	preg_match ("/^(\/[a-zA-Z0-9]+)(\@LazyBibleBot)?$/", $text, $matches);
	return $matches[1];
}

function process_text ($text, $from) {

	$username = getUsername($from);
	$id = getId($from);
	$command = getCommand($text);


	$userController = new UserController ();
	$user = new User ($id, $username, NULL, NULL);

	if ($userController -> exists($user)) {
		$user = $userController->retrieve_id($id);
	}
	

	if ($command == "/start") {
		subscribe ($user, $userController);
	} else if ($command == "/sethour") {
		getHour ($user, $userController);
	} else if ($command == "/gethour") {
		sendHour ($user, $userController);
	} else if ($command == "/getverse") {
		getVerse ($user, $userController);
	} else if ($command == "/subscribers") {
		getSubscriber ($user, $userController);
	} else if ($command == NULL) {
		if (User::IS_SET_HOUR_COMMAND($user->getCommand())) {
			setHour ($user, $userController, $text);
		} else if (User::IS_SET_VERSE_COMMAND($user->getCommand())) {
			processRequestedVerse ($user, $userController, $text);
		}
	}

}

webhookCalled();

?>

