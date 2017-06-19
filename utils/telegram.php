<?php
require_once ("http.php");

define ('TELEGRAM_API', "https://api.telegram.org/bot");
define ('BOT_TOKEN', '442396978:AAERK7i9NtJa2CbwKwEgOp7Wmn5L4gtgV7E');

/* ============================
	
		Telegram API

============================ */

function getUpdate () {
	return json_decode(getRequest ("https://api.telegram.org/bot".BOT_TOKEN."/getUpdates"));
}

function sendMessageUrl ($chatId, $msg) {
	return TELEGRAM_API.BOT_TOKEN."/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($msg) ."&disable_web_page_preview=true";
}

function sendForceReplyMessageUrl ($chatId, $msg) {
	$forceReply = [];
	$forceReply['force_reply'] = true;

	$url = sendMessageUrl($chatId, $msg) . "&reply_markup=" . json_encode($forceReply);
	return $url;
}

function sendMessage ($chatId, $msg) { return json_decode(getRequest(sendMessageUrl($chatId, $msg))); }
function sendForceReply ($chatId, $msg) { return json_decode(getRequest(sendForceReplyMessageUrl($chatId, $msg))); }

?>