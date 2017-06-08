<?php
function setHour ($user, $userFactory, $hours) {
	$hours = explode(",", $hours);

	$setTo = "";
	$invalid = "";

	$commaFlag = false;
	$comma = "";

	foreach ($hours as $hour) {
		if ($commaFlag) {
			$comma = ",";
		} else {
			$commaFlag = true;
		}

		if (intval($hour) < 0 || intval($hour) > 24) {
			$invalid .= $comma.$hour;
		} else {
			$setTo .= $comma.$hour;
		}
	}

	$user->setHour($setTo);
	$userFactory->update($user);

	$msg = "Alright! Sending at " . $setTo . "Hrs";
	if ($invalid != "") 
		$msg .= "\nAnd Hello! Time is only between 0 to 24!!";


	sendMessage ($user->getChatId(), $msg);
	
}
?>