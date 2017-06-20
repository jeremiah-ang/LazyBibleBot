<?php
function getter($user, $userController, $command, $msg) {
	$user->setCommand ($command);
	$userController->update($user);
	sendForceReply($user->getChatId(), $msg);
}
?>