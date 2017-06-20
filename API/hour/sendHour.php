<?php
function sendHour ($user, $userController) {
	sendMessage ($user->getChatId(), "You're receiving at:\n" . $user->getHour() . "Hrs :)");
}
?>