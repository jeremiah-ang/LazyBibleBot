<?php
require_once ('utils/telegram.php');

function subscribe ($user, $userController) {
	if (!$userController->exists($user)) {
		$user->setHour ("9,12,17,21");
		$userController->create($user);
		sendMessage ($user->getChatId(), "Subscribed! \nYou'll receive a verse at 9, 12, 17 and 21 Hour! \n use /sethour to change the hour to receive a verse :)");
	}
}
?>