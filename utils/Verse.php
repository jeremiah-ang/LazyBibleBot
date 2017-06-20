<?php
class Verse {

	var $passage;
	var $title;
	var $fullVerse;
	var $book;
	var $chapter;
	var $verseStart;
	var $verseEnd;
	var $msg;
	var $plainVerse;

	function __construct ($passage) {

		$this->passage = $passage;
		$arr = $this->getArrayVerse();

		$this->title = $arr[1];
		$this->fullVerse = $arr[2];
		$this->book = $arr[3];
		$this->chapter = $arr[4];
		$this->verseStart = $arr[5];
		$this->verseEnd = $arr[6];
		$this->msg = $arr[7];

		
		$this->plainVerse = $this->getPlainVerse ();
	}

	function setBook ($book) { 
		$this->book = $book; 
		$this->updateFullVerse();
	}

	function updateFullVerse () {
		$fullVerse = $this->book . " " . $this->chapter;
		if ($this->verseStart) {
			$fullVerse .= ":" . $this->verseStart;
			if ($this->verseEnd) {
				$fullVerse .= "-" . $this->verseEnd;
			} 
		}
		$this->fullVerse = $fullVerse;

	}

	function getArrayVerse () {
		preg_match("/(.?)<b>\s*?(([0-9]?\s?[a-zA-Z]*)\s?([0-9]+):([0-9]+)-?([0-9]+)?)\s*?<\/b>(.+)/", $this->passage, $match);
		return $match;
	}

	function getPlainVerse () {
		return ($this->plainVerse) 
			? $this->plainVerse 
			: (is_null($this->title))
				? $this->fullVerse . "\n" . trim($this->msg)
				: $this->title . "\n" . $this->fullVerse . "\n" . trim($this->msg);
	}

	function getBibleGatewayUrl () {
		$verse = 
			trim($this->book)
			. "+" 
			. trim($this->chapter);
		print_r($this->book);
			
		return "https://www.biblegateway.com/passage/?search=".urlencode($verse);
	}
}
?>