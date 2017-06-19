<?php

function getSubscriber ($user, $userController) {
	$allUsers = $userController->getAllUsers();
	$msg = "";
	$currentUser;

	for($i = 0; $i < count($allUsers); $i++) {
		$currentUser = $allUsers[$i];
		$msg .= $currentUser->getUsername() . ": " . $currentUser->getHour() . "\n";
	}

	sendMessage($user->getChatId(), $msg);
}

?>