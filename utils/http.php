<?php

/* ============================
	
		HTTP/HTTPS API

============================ */

function getRequest ($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($curl);
	return $response;
}


?>