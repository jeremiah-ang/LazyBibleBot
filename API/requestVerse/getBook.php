<?php 
function getBook($user, $userController, $options) {
	$user->setCommand (User::$SET_BOOK_COMMAND);
	$userController->update($user);
	sendInlineMessage($user->getChatId(), "Did You Mean...", $options);
}
?>