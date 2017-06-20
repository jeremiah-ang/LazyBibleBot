<?php
require_once ("sendRequestedVerse.php");
require_once ("getBook.php");
function processRequestedVerse($user, $userController, $verse) {

	preg_match("/([0-9]*\s*[a-zA-Z]+)\s*([0-9]+)\s*:\s*([0-9]+)(\s*-\s*([0-9]+))?/", $verse, $matches);

	$book = $matches[1];
	$chapter = $matches[2];
	$verseStart = $matches[3];
	$verseEnd = $matches[5];

	if (is_null($book)) {
		return sendMessage ($user->getChatId(), "mmmm.... <book> <chapter>:<verse start>-<verse end> :)");
	}
	if (is_null($chapter)) {
		return sendMessage ($user->getChatId(), "Cannot retrieve whole book O.O!!!");
	}
	if (is_null($verseStart)) {
		return sendMessage ($user->getChatId(), "Cannot retrieve whole chapter O.O");
	}

	$bible = new Bible();
	$bookSuggestion = $bible->get_books($book);
	if (count($bookSuggestion) > 1) {
		return getBook ($user, $userController);
	} 

	sendRequestedVerse($user, $userController, $bible, $book, $chapter, $verseStart, $verseEnd);
}
?>