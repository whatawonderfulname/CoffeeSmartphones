<?php 
	session_start();

	include "../services/session_cart.php";
	
	// add a product to the cart
	if ($_POST) {
		$product = json_decode($_POST["product"], true);
		$match = false;
		$message = "";

		// if the product is already in the cart, increase the amount requested
		for ($i = 0; $i < count($_SESSION["products"]); $i++) {
			if 
			($_SESSION["products"][$i]["category"] == $product["category"] 
			&& $_SESSION["products"][$i]["id"] == $product["id"]) 
			{
				if 
				($_SESSION["products"][$i]["amount_available"] 
				> $_SESSION["products"][$i]["amount_requested"]) 
				{
					$_SESSION["products"][$i]["amount_requested"]++;
					$_SESSION["total_items"]++;
					$match = true;

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

		// if the product in not yet in the cart, add it with an amount requested of 1
		if (! $match) {
			$product["amount_requested"] = 1;
			array_push($_SESSION["products"], $product);
			$_SESSION["total_items"]++;
		}

		// if there are enough products available show a success message to the user
		if ($message == "") {
			$message = "1 item of " . $product["name"] . " has been added to the cart.";
		}

		$array = [$_SESSION["total_items"], $message];

		// send the total items count and a message as a response
		echo json_encode($array);
	}
?>