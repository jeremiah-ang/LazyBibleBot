<?php
require_once ("http.php");

define ('BOT_TOKEN', '442396978:AAERK7i9NtJa2CbwKwEgOp7Wmn5L4gtgV7E');

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

function sendForceReply ($chatId, $msg) {
	$forceReply = [];
	$forceReply['force_reply'] = true;

	$url = "https://api.telegram.org/bot".BOT_TOKEN."/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg) . "&reply_markup=" . json_encode($forceReply);

	return json_decode(getRequest ($url));
}

?>