<?php 
function setBook ($user, $userController, $book) {
	if ($book == "Cancel") {
		$user->setCache("NULL");
		$user->setCommand("NULL");
		return $userController->update($user);
	}
	$matches = Bible::split_verse($book . " " . $user->getCache());
	sendRequestedVerse($user, $userController, new Bible(), $matches[1], $matches[2], $matches[3], $matches[5]);
}
?>