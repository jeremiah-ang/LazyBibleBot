<?php
function setHour ($user, $userFactory, $hours) {
	$hours = explode(",", $hours);

	$setTo = "";
	$invalid = "";

	$commaFlag = false;
	$comma = "";

	foreach ($hours as $hour) {

		$hour = trim($hour);

		if (!is_numeric($hour) || intval($hour) < 0 || intval($hour) > 24) {
			$invalid .= $comma.$hour;
		} else {
			if ($commaFlag) {
				$comma = ",";
			} else {
				$commaFlag = true;
			}

			$setTo .= $comma.$hour;
		}
	}

	$msg = "Hello! Time is only between 0 to 24!!";
	if (trim($setTo) != "") {
		$msg = "Alright! Sending at " . $setTo . "Hrs";
		if ($invalid != "") 
			$msg .= "\nAnd Hello! Time is only between 0 to 24!!";
	} 

	sendMessage ($user->getChatId(), $msg);

	$user->setHour($setTo);
	$user->setCommand('NULL');
	$userFactory->update($user);
	
}
?>