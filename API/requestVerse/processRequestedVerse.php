<?php
require_once ("sendRequestedVerse.php");
require_once ("getBook.php");
function processRequestedVerse($user, $userController, $verse) {

	$matches = Bible::split_verse($verse);

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
		$verse = $chapter . ":" . $verseStart;
		if ($verseEnd)
			$verse .= "-" . $verseEnd;

		$user->setCache($verse);
		return getBook ($user, $userController, $bookSuggestion);
	} 

	if (count($bookSuggestion) > 0) 
		$book = $bookSuggestion[0];

	sendRequestedVerse($user, $userController, $bible, $book, $chapter, $verseStart, $verseEnd);
}
?>