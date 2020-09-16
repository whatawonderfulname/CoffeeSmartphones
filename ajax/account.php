<?php  
	session_start();

	include "../services/main.php";
	include "../services/database_connection.php";
	include "../services/session_cart.php";

	// update billing details entries, so that a new entry becomes default
	if ($_POST) {

		// remove the default property
	    $sql = "update `billing_details` 
	    set `by_default` = 0 
	    where `fk_user` = {$_SESSION['user']} 
	    and `by_default` = 1";
	    $connection->query($sql);

	    // set the default property
	    $sql = "select * from `billing_details` 
	    where `fk_user` = {$_SESSION['user']}";
	    $result = $connection->query($sql);

	    while ($option = $result->fetch_assoc()) {
	        if ($option["id"] == $_POST["id"]) {
	        	$sql = "update `billing_details` 
	        	set `by_default` = 1 
	        	where `id` = {$option['id']}";
	        	$connection->query($sql);
	        	break;
	        }
	    }
	    
	    $connection->close(); 
	}
?>