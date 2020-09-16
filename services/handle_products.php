<?php
	include_once __DIR__ . "/main.php";
	include_once __DIR__ . "/database_connection.php";

	// get reviews
	$sql = "select * from `review`";
	$result = $connection->query($sql);
	$reviews = $result->fetch_all(MYSQLI_ASSOC);
	$products = [];

	function getProducts($name) {
		global $connection;
		global $reviews;
		global $products;
		$sql = "select * from `{$name}` where `amount_available` > 0 and `visible` = 1";
		$result = $connection->query($sql);

		while ($product = $result->fetch_assoc()) // fetches a result row as an associative array while there is a row to fetch
		{
			// create additional attributes for each product:
			// category
			$product["category"] = $name;

			// old price and new price
			if ($product["discount"] > 0) {
				$product["old_price"] = $product["price"];
				$product["new_price"] = round($product["price"] * (100 - $product["discount"])) / 100;
			} else {
				$product["old_price"] = "";
				$product["new_price"] = $product["price"];
			}

			// ratings and average of stars
			$product["ratings"] = 0;
			$sum = 0;

			foreach ($reviews as $review) {
				$foreignKey = "fk_{$name}";
				if ($review[$foreignKey] == $product["id"]) {
					$product["ratings"]++;
					$sum += $review["stars"];
				}
			}

			if ($product["ratings"] != 0) {
				$product["stars"] = round($sum / $product["ratings"]);
			} else {
				$product["stars"] = 0;
				$product["ratings"] = "";
			}

			array_push($products, $product);
		}
	}

	getProducts("smartphone");
	getProducts("cover");
	getProducts("headphone");
	getProducts("charger");
?>