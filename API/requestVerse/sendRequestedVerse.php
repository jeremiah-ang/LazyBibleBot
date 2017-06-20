<?php
function sendRequestedVerse ($user, $userController, $bible, $book, $chapter, $verseStart, $verseEnd) {
	$fullVerse = $book 
		. " " 
		. $chapter 
		. ":" 
		. $verseStart;

	if (!is_null($verseEnd)) {
		$fullVerse .= "-" . $verseEnd;
	}

	$verseObj = $bible->getVerse(urlencode($fullVerse));
	$verseObj->setBook($book);
	$verseObj->setFullVerse($fullVerse);

	if (is_null($verseObj)) {
		sendMessage($user->getChatId(), "ITS NULL!");
	} else
		sendMessage($user->getChatId(), $verseObj->getPlainVerse()); 

	$user->setCommand("NULL");
	$user->setCache("NULL");
	$userController->update($user);
}
?>