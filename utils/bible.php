<?php 
require_once ("http.php");
require_once ("Verse.php");

/* ============================
	
		   Bible API

============================ */

class Bible {
	function getVerse ($passage) {
		$votdUrl = "http://labs.bible.org/api/?passage=".$passage;
		return new Verse(getRequest ($votdUrl));
	}
}
?>