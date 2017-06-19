<?php
require_once ('utils/bible.php');
require_once ('utils/fileSystem.php');
require_once ('utils/http.php');
require_once ('utils/telegram.php');
require_once ('utils/User.php');
require_once ('utils/UserController.php');
require_once ('API/subscribe.php');
require_once ('API/setHour.php');
require_once ('API/getHour.php');
require_once ('API/getSubscriber.php');

function webhookCalled () {
	$content = file_get_contents("php://input");
	$update = json_decode($content, true);
	$text = $update['message']['text'];

	process_text ($text, $update['message']['from']);
}

function process_text ($text, $from) {

	$textArray = explode(" ", $text);
	$command = $textArray[0];

	$username = ($from['username']) 
				? $from['username'] 
				: $from['first_name'];
	$id = $from['id'];

	$userController = new UserController ();
	$user = new User ($id, $username, NULL, NULL);

	if ($userController -> exists($user)) {
		$user = $userController->retrieve_id($id);
	}


	if ($command == "/start") {
		subscribe ($user, $userController);
	} else if ($command == "/sethour") {
		getHour ($user, $userController);
	} else if ($command == "/subscribers") {
		getSubscriber ($user, $userController);
	} else {
		if (User::IS_SET_HOUR_COMMAND($user->getCommand ())) {
			$hour = $text;
			setHour ($user, $userController, $hour);
		} else {
			sendMessage ($user->getChatId(), "Invalid Command~");
		}
	}

}

webhookCalled();

?>

