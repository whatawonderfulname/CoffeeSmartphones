<?php 
	session_start();
	
	include "../services/session_cart.php";

	// change the requested amount of a product
	if ($_POST) {
		$message = "";

		// perform the required action on a product / products:
		// clear
		if ($_POST["action"] == "clear") {
			$_SESSION["products"] = [];
			$_SESSION["total_items"] = 0;
		} 

		// delete
		else if ($_POST["action"] == "delete") {
			for ($i = 0; $i < count($_SESSION["products"]); $i++) {
				if 
				($_SESSION["products"][$i]["category"] 
				== $_POST["category"] 
				&& $_SESSION["products"][$i]["id"] 
				== $_POST["id"]) 
				{
					$_SESSION["total_items"] 
					-= $_SESSION["products"][$i]["amount_requested"];
					array_splice($_SESSION["products"], $i, 1);
					break;
				}
			}
		} 

		// decrease
		else if ($_POST["action"] == "decrease") {
			for ($i = 0; $i < count($_SESSION["products"]); $i++) {
				if 
				($_SESSION["products"][$i]["category"] 
				== $_POST["category"] 
				&& $_SESSION["products"][$i]["id"] 
				== $_POST["id"]) 
				{
					$_SESSION["products"][$i]["amount_requested"]--;
					if
					($_SESSION["products"][$i]["amount_requested"] == 0) 
					{
						array_splice($_SESSION["products"], $i, 1);
					}
					break;
				}
			}
			$_SESSION["total_items"]--;
		} 

		// increase
		else if ($_POST["action"] == "increase") {
			for ($i = 0; $i < count($_SESSION["products"]); $i++) {
				if 
				($_SESSION["products"][$i]["category"] 
				== $_POST["category"] 
				&& $_SESSION["products"][$i]["id"] 
				== $_POST["id"]) 
				{
					if 
					($_SESSION["products"][$i]["amount_available"] 
					> $_SESSION["products"][$i]["amount_requested"]) 
					{
						$_SESSION["products"][$i]["amount_requested"]++;
						$_SESSION["total_items"]++;
					} else {
						if 
						($_SESSION["products"][$i]["amount_available"] == 1) 
						{
							$message = "Unfortunately, there is only " 
							. $_SESSION["products"][$i]["amount_available"] 
							. " item of " 
							. $_SESSION["products"][$i]["name"] 
							. " available.";
						} else {
							$message = "Unfortunately, there are only " 
							. $_SESSION["products"][$i]["amount_available"] 
							. " items of " 
							. $_SESSION["products"][$i]["name"] 
							. " available.";
						}
					}
					break;
				}
			}
		}

		$array = [
			$_SESSION["products"],
			$_SESSION["total_items"], 
			$message
		];

		// send the modified array as a response
		echo json_encode($array);
	}
?>