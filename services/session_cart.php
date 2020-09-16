<?php 
	if (! isset($_SESSION["products"])) {
		$_SESSION["products"] = [];
	}
	
	if (! isset($_SESSION["total_items"])) {
		$_SESSION["total_items"] = 0;
	}
?>