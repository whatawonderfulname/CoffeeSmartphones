<?php

	// establish a connection with the database
	$connection = new mysqli($myHost, $myUser, $myPassword, $myDatabase);
	
	if ($connection->connect_error) {
	    die("Connection failed: " . $connection->connect_error);
	}
?>