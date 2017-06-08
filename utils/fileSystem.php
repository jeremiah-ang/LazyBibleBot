<?php

/* ============================
	
		FILE SYSTEM API

============================ */

function readJSON ($file) {
	return json_decode(file_get_contents($file));
}

function writeJSONToFile ($file, $json) {
	$fp = fopen ($file, 'w');
	fwrite($fp, json_encode($json));
	fclose($fp);
}


?>