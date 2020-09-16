<?php  

	// display or don't display buttons depending on who should be able see them
	if (isset($_SESSION["user"])) {
		$userButton = "";
	} else {
		$userButton = 'style="display: none;"';
	}
	
	if (isset($_SESSION["admin"])) {
		$adminButton = "";
	} else {
		$adminButton = 'style="display: none;"';
	}
?>