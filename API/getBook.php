<?php
function getBook ($user, $userController) {
	$user->setCommand (User::$SET_BOOK_COMMAND);
	$userController->update($user);
	sendForceReply($user->getChatId(), "Enter Book Name");
}
?>