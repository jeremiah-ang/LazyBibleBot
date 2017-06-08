<?php
require_once ("http.php");

define ('BOT_TOKEN', '386938857:AAHnHyE1XOfw31wELyKhvtDvyvUeSbUIuV4');

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