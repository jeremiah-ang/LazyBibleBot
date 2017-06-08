<?php
require_once ("http.php");

/* ============================
	
		Telegram API

============================ */

function getUpdate () {
	return json_decode(getRequest ("https://api.telegram.org/bot".BOT_TOKEN."/getUpdates"));
}

function sendMessage ($chatId, $msg) {
	$url = "https://api.telegram.org/bot".BOT_TOKEN."/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg);

	return json_decode(getRequest ($url));
}

?>