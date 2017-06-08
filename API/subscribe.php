<?php
require_once ('utils/telegram.php');

function subscribe ($user, $userController) {
	if (!$userController->exists($user)) {
		$userController->create($user);
		sendMessage ($user->getChatId(), "Subscribed!");
	}
}
?>