<?php 
require_once ("http.php");

/* ============================
	
		   Bible API

============================ */

function getVerse ($passage) {
	$votdUrl = "http://labs.bible.org/api/?passage=".$passage;
	return getRequest ($votdUrl);
}


?>