<?php
function setBook ($user, $userController, $book) {
	$user->setCache (User::$SET_BOOK_COMMAND);
	$userController->update($user);
	sendForceReply($user->getChatId(), "Enter Book Name");
}
?>