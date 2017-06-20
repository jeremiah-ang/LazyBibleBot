<?php
function getHour ($user, $userController) {
	getter ($user, $userController, User::$SET_HOUR_COMMAND, "Enter comma seperated values\ni.e. 9, 12, 18, 22");
}
?>