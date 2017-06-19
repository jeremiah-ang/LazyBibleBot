<?php

function getHour ($user, $userController) {
	$user->setCommand (User::$SET_HOUR_COMMAND);
	$userController->update($user);
	sendForceReply($user->getChatId(), "Enter comma seperated values");
}

?>